@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h3 class=" mt-2 mb-4">Başvurularım</h3>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white ">
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table table-sm fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>Profil</th>
                            <th>Teklif Veren</th>
                            <th style="width:200px">Proje Başlığı</th>
                            <th>İsim</th>
                            <th>Telefon</th>
                            <th>Meslek</th>
                            <th>E-mail</th>
                            <th>Açıklama</th>
                            <th>Yanıt Durumu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xl mr-2">
                                            <img src="{{ asset('storage/profile_images/' . $item->user->profile_image) }}"
                                                class="avatar-img rounded-circle" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td> {{ $item->user->name }} <br><br>
                                    <span style="font-size: 10px;color:black;font-weight:700">
                                        {{ $item->city ? $item->city->title : null }}
                                        {{ $item->district ? ' - ' . $item->district->ilce_title : null }}</span>
                                </td>

                                <td>{{ $item->project->project_title . ' Projesindeki ' . $item->room_id . " No'lu İlan" }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->title }}</td>

                                <td>{{ $item->email }}</td>
                                <td>{{ $item->offer_description }}</td>
                                <td>

                                    @if (!$item->response_description)
                                        Henüz yanıtlanmadı
                                        <span class="badge badge-warning">Henüz Yanıtlanmadı</span>
                                    @else
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#responseModalYanit{{ $item->id }}" >
                                        Yanıtı Gör
                                    </button>       

                                    @endif
                                </td>

                            </tr>

                               <!--Yanıtı Gör Modal -->
                               <div class="modal fade" id="responseModalYanit{{ $item->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="responseModalYanitLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="responseModalYanitLabel{{ $item->id }}">Yanıt
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                              
                                                {{-- <div class="form-group">
                                                    <label class="form-label" for="response">Yanıtınız</label>
                                                    <textarea class="form-control" id="content_{{ $item->id }}" name="response" rows="10" required>
                                                        {{ $item->response_description }}
                                                    </textarea>
                                                </div> --}}

                                                <div class="form-group">
                                                    <p>  {!! $item->response_description !!}</p>
                                                </div>

                                            
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Kapat</button>
                                                    <button type="submit" class="btn btn-info">Yanıtla</button>
                                                </div>
                                           
                                        </div>
                                    </div>
                                </div>
                            </div>
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
            // CKEDITOR oluşturma fonksiyonu
            function createEditor(itemId) {
                var editorId = 'content_' + itemId; // CKEDITOR'ün benzersiz ID'si
                CKEDITOR.replace(editorId, {
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });
            }

            // Sayfa yüklendiğinde tüm CKEDITOR'leri oluştur
            @foreach ($data as $item)
                createEditor({{ $item->id }});
            @endforeach

            // CKEDITOR içeriğini almak için bir fonksiyon
            function getContent(itemId) {
                return CKEDITOR.instances['content_' + itemId].getData();
            }
        });
    </script>
@endsection
