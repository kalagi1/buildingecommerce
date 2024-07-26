@extends('client.layouts.masterPanel')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="table-breadcrumb">
        <ul>
            <li>Hesabım</li>
            <li>Projelere Yaptığım Başvurular</li>
        </ul>
    </div>
</div>
    <div class="content">
            @foreach ($data as $index => $item)
                <div class="project-table-content">
                    <ul>
                        <li style="width: 5%;">{{ $index + 1 }}</li>
                     
                        <li style="width: 20%;">
                            {{ $item->project->user->name }} <br>
                            <span style="font-size: 10px;color:black;font-weight:700">
                                {{ $item->city ? $item->city->title : null }}
                                {{ $item->district ? ' - ' . $item->district->ilce_title : null }}</span>
                        </li>
                        <li style="width: 30%;">
                            {{ $item->project->project_title . ' Projesindeki ' . $item->room_id . " No'lu İlan" }}
                        </li>
                        <li style="width: 10%;">
                            {{ $item->price }}
                        </li>
                        <li style="width: 10%;">
                            {{ $item->name }}
                        </li>
                        <li style="width: 10%;">
                            {{ $item->phone }}
                        </li>
                        <li style="width: 10%;">
                            {{ $item->title }}
                        </li>
                        <li style="width: 10%;">
                            {{ $item->email }}
                        </li>
                        <li style="width: 20%;">
                            {{ $item->offer_description }}
                        </li>
                        <li style="width: 15%;">
                            @if (!$item->response_description)
                                <span class="badge badge-warning">Henüz Yanıtlanmadı</span>
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#responseModalYanit{{ $item->id }}">
                                    Yanıtı Gör
                                </button>
                            @endif
                        </li>
                    </ul>
                    
                    <!-- Yanıtı Gör Modal -->
                    @if ($item->response_description)
                        <div class="modal fade" id="responseModalYanit{{ $item->id }}" tabindex="-1"
                            role="dialog" aria-labelledby="responseModalYanitLabel{{ $item->id }}"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="responseModalYanitLabel{{ $item->id }}">Yanıt</h5>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <p>{!! $item->response_description !!}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
    </div>
@endsection

@section('scripts')
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

            @foreach ($data as $item)
                createEditor({{ $item->id }});
            @endforeach

            // CKEDITOR içeriğini almak için bir fonksiyon
            function getContent(itemId) {
                return CKEDITOR.instances['content_' + itemId].getData();
            }
        });
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endsection

@section('css')
    <style>
        .custom-control-input:checked+.custom-control-label::before {
            background-color: green !important;
        }

        .custom-control-input:not(:checked)+.custom-control-label::before {
            background-color: red !important;
        }
        .profile-initial {
            font-size: 20px;
            color: #e54242;
            background: white;
            padding: 5px;
            border: 1px solid #e6e6e6;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
        }
    </style>
@endsection
