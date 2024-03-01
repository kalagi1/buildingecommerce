@extends('institutional.layouts.master')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

@section('content')
<div class="content">
   <h3 class="text-center mt-2 mb-4" text-center mt-2 mb-4>Alınan Teklifler</h3>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-7 border-y border-300">
        <div class="table-responsive mx-n1 px-1 scrollbar">
            <table class="table table-sm border-top border-200 fs--1 mb-0">
                <thead>
                    <tr>
                        <th>Teklif Eden</th>
                        <th>Proje Başlığı</th>
                        <th>E-mail</th>
                        <th>Teklif Aralığı</th>
                        <th>Açıklama</th>
                        <th>Yanıtla</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl mr-2">
                                        <img src="{{ asset('storage/profile_images/' . $item->user->profile_image) }}" class="avatar-img rounded-circle" alt="">
                                    </div>
                                    <div>
                                        {{ $item->user->name }}
                                    </div>
                                </div>
                            </td>
                            
                            <td>{{ $item->project->project_title. " Projesindeki ". $item->room_id ." No'lu İlan" }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->offer_price_range }}</td>
                            <td>{{ $item->offer_description }}</td>
                            <td>   
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#responseModal{{ $item->id }}">
                                    Yanıtla
                                </button>
                            </td>
                        </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="responseModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="responseModalLabel{{ $item->id }}">Yanıtla</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{route('offer_response')}}">
                                                @csrf
                                                <input type="hidden" name="email" value="{{$item->email}}">
                                                <input type="hidden" name="username" value="{{ \App\Models\User::find($item->user_id)->name }}">
                                                <input type="hidden" name="offer_id" value="{{ $item->id }}">
                                                <input type="hidden" name="offer_info" value="{{ $item->project->project_title. " Projesindeki ". $item->room_id ." No'lu İlan" }}">
                                                <div class="form-group">                                          
                                                        <label class="form-label" for="response">Yanıtınız</label>
                                                        <textarea class="form-control" id="content_{{ $item->id }}" name="response" rows="10" required></textarea>
                                                </div>          
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" id="response_toggle{{ $item->id }}" name="response_toggle"
                                                        data-onstyle="success"
                                                        onchange="updateResponseText({{ $item->id }})">
                                                        <label class="custom-control-label" for="response_toggle{{ $item->id }}">Olumsuz Değerlendirildi</label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                                                    <button type="submit" class="btn btn-info">Yanıtla</button>
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
    </div>


    <div class="container mt-5">

    <h3 class="text-center mt-2 mb-4" text-center mt-2 mb-4>Yanıtlanan Teklifler</h3>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-7 border-y border-300">
        <div class="table-responsive mx-n1 px-1 scrollbar">
            <table class="table table-sm border-top border-200 fs--1 mb-0">
                <thead>
                    <tr>
                        <th>Teklif Eden</th>
                        <th>Proje Başlığı</th>
                        <th>Oda No</th>
                        <th>E-mail</th>
                        <th>Teklif Aralığı</th>
                        <th>Açıklama</th>
                        <th>Yanıt Durumu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                        @if($item->offer_response == 1)
                            <tr>
                                <td>{{ \App\Models\User::find($item->user_id)->name }}</td>
                                <td>{{ \App\Models\Project::find($item->project_id)->project_title }}</td>
                                <td>{{ $item->room_id }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->offer_price_range }}</td>
                                <td>{{ $item->offer_description }}</td>
                                <td>
                                    @if($item->response_status == 0)
                                        <span class="badge badge-danger">Olumsuz</span>
                                    @elseif($item->response_status == 1)
                                        <span class="badge badge-success">Olumlu</span>
                                    @endif
                                </td>
                            </tr>
                        @endif    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
   </div>
</div>

@endsection



@section('scripts')
<script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>

<script>
    function uncheckNegative(itemId) {
        document.getElementById('negative_response' + itemId).checked = false;
    }

    function uncheckPositive(itemId) {
        document.getElementById('positive_response' + itemId).checked = false;
    }


    
    $(document).ready(function() {
        // CKEDITOR oluşturma fonksiyonu
        function createEditor(itemId) {
            var editorId = 'content_' + itemId; // CKEDITOR'ün benzersiz ID'si
            CKEDITOR.replace(editorId, {
                filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        }

        // Sayfa yüklendiğinde tüm CKEDITOR'leri oluştur
        @foreach($data as $item)
            createEditor({{ $item->id }});
        @endforeach

        // CKEDITOR içeriğini almak için bir fonksiyon
        function getContent(itemId) {
            return CKEDITOR.instances['content_' + itemId].getData();
        }
    });


    //  tinymce.init({
    //     selector: 'textarea#body', // Hedef elementin id'si
    //     plugins: 'link code anchor autolink charmap codesample emoticons image lists media searchreplace table visualblocks wordcount', // İhtiyacınıza göre eklentileri ayarlayabilirsiniz
    //     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    //     menubar: true,
    //     branding: true
    // });
</script>

<script>
    function updateResponseText(itemId) {
        var toggle = document.getElementById('response_toggle' + itemId);
        var label = document.querySelector('label[for=response_toggle' + itemId + ']');
        if (toggle.checked) {
            label.textContent = 'Olumlu Değerlendirildi';
        } else {
            label.textContent = 'Olumsuz Değerlendirildi';
        }
    }
</script>
@endsection

{{-- @section('scripts')

<script src="https://cdn.tiny.cloud/1/uzaxwtnfjkyj1l9egzl3mea3go0cq6xgmlkoanf5eb2jry8u/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
     CKEDITOR.replace('content', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    //  tinymce.init({
    //     selector: 'textarea#body', // Hedef elementin id'si
    //     plugins: 'link code anchor autolink charmap codesample emoticons image lists media searchreplace table visualblocks wordcount', // İhtiyacınıza göre eklentileri ayarlayabilirsiniz
    //     toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    //     menubar: true,
    //     branding: true
    // });
</script>
@endsection --}}

@section('css')
<style>
   .custom-control-input:checked + .custom-control-label::before {
        background-color: green !important;
    }

    .custom-control-input:not(:checked) + .custom-control-label::before {
        background-color: red !important;
    }


</style>
@endsection