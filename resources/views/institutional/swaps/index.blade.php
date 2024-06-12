@extends('institutional.layouts.master')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

@section('content')
    <div class="content">
        <h3 class=" mt-2 mb-4">Gelen Takas Başvuruları</h3>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white">
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table table-sm  border-200 fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Profil</th>
                            <th>İsim</th>
                            <th>Soyad</th>
                            <th>Telefon</th>
                            <th>E-mail</th>
                            <th>Detaylar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apps as $index => $app)
                            <tr>
                                <td>
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl mr-2">
                                            @if ($item->user->profile_image == 'indir.png')
                                                @php
                                                    $nameInitials = collect(preg_split('/\s+/', $item->user->name))
                                                        ->map(function ($word) {
                                                            return mb_strtoupper(mb_substr($word, 0, 1));
                                                        })
                                                        ->take(1)
                                                        ->implode('');
                                                @endphp

                                                <div class="profile-initial"
                                                    style="margin: inherit !important;margin-left: 0 !important">
                                                    {{ $nameInitials }}</div>
                                            @else
                                                <img loading="lazy"
                                                    src="{{ asset('storage/profile_images/' . $item->user->profile_image) }}"
                                                    alt="{{ $item->user->name }}" class="avatar-img rounded-circle"
                                                    style="object-fit:contain;">
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $app->ad }}</td>
                                <td>{{ $app->soyad }}</td>
                                <td>{{ $app->telefon }}</td>
                                <td>{{ $app->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $app->id }}">
                                        Detaylar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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

