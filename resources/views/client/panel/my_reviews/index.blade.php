@extends('client.layouts.masterPanel')


@section('content')
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div class="table-breadcrumb">
            <ul>
                <li>Hesabım</li>
                <li> Değerlendirmelerim
                </li>
            </ul>
        </div>
    </div>
    <div class="text-header p-0" id="yeniMusteriler" style="border-radius:7px;">
        <div class="d-flex" style="justify-content: space-between;">
            <input type="text" id="search-input-yeni" placeholder="Ara..." class="search-input form-control">
        </div>

        <div class="project-table-content user-item">
            <ul style="gap: 20px">
                <li style="width: 0%;">No.</li>
                <li style="width: 10%;">İlan Adı</li>
                <li style="width: 10%;">İlan Numarası</li>
                <li style="width: 15%;">Yorum</li>
                <li style="width: 10%;">Değerlendirme</li>
                <li style="width: 10%;">Emlak / Proje</li>
                <li style="width: 10%;">Durum</li>
                <li style="width: 15%;">Tarih</li>
                <li style="width: 5%;">Düzenle</li>
            </ul>
        </div>

        <div id="commentTable">
            @foreach ($all_comments as $key => $comment)
                <div class="project-table-content user-item">
                    <ul style="gap: 20px">
                        <li style="width: 0%;">{{ $key + 1 }}</li>
                        <li style="width: 10%; align-items: flex-start;">
                            @if ($comment->type == 'Emlak')
                                <span>{{ $comment->housing->name ?? 'N/A' }}</span>
                            @else
                                <span>{{ $comment->project->project_title ?? 'N/A' }}</span>
                            @endif
                        </li>
                        <li style="width: 10%; align-items: flex-start;">
                            @if ($comment->type == 'Emlak')
                                {{ $comment->housing->id + 2000000 }}
                            @else
                                {{ $comment->project->id + 1000000 }}
                            @endif
                        </li>
                        <li style="width: 15%; align-items: flex-start; word-wrap: break-word; word-break: break-all;">
                            <span>{{ $comment->comment }}</span>
                        </li>
                        <li style="width: 10%;flex-direction: row !important;">
                            @if ($comment->rate)
                                @for ($i = 0; $i < $comment->rate; $i++)
                                    <svg viewBox="0 0 14 14" class="widget-svg" style="width: 10.89px; height: 10.89px;">
                                        <path class="star"
                                            d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                            style="fill: rgb(255, 192, 0);"></path>
                                    </svg>
                                @endfor
                            @endif
                        </li>
                        <li style="width: 10%; align-items: flex-start;">
                            <span>{{ $comment->type }}</span>
                        </li>
                        <li style="width: 10%; align-items: flex-start;">
                            @if ($comment->status == '1')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Pasif</span>
                            @endif
                        </li>
                        <li style="width: 15%; align-items: flex-start;">
                            <span>{{ $comment->created_at->locale('tr')->isoFormat('D MMM, HH:mm') }}</span>
                        </li>
                        <li style="width: 5%; align-items: flex-start;">
                            <button class="btn btn-warning edit-button" data-id="{{ $comment->id }}" data-type="{{ $comment->type }}">Düzenle</button>
                        </li>
                    </ul>
                </div>
            @endforeach
        </div>
        
        <div id="pagination-controls" class="d-flex" style="margin-top: 20px; justify-content: space-between !important;">
            <button id="prev-page" class="btn btn-primary" disabled>Önceki</button>
            <span id="page-info"></span>
            <button id="next-page" class="btn btn-primary">Sonraki</button>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- search bar script --}}
    <script>
        $(document).ready(function() {
            function filterTable(searchInputId, tableBodyId) {
                $(searchInputId).on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    console.log(value)

                    $(tableBodyId + ' .user-item').each(function() {
                        var text = $(this).text().toLowerCase();
                        console.log(text)
                        $(this).toggle(text.indexOf(value) > -1);
                    });
                });
            }
            // Arama kutuları ve tablo gövdesi
            filterTable('#search-input-yeni', '#commentTable');
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Function to handle editing comments
            function handleEditButtonClick() {
                $('.edit-button').on('click', function() {
                    var commentId = $(this).data('id');
                    var commentType = $(this).data('type');
                    var url, updateUrl;
    
                    // Set URLs based on comment type
                    if (commentType === 'Emlak') {
                        url = `{{ route('housing.get-comment', '') }}/${commentId}`;
                        updateUrl = `{{ route('housing.update-comment') }}`;
                    } else {
                        url = `{{ route('project.get-comment', '') }}/${commentId}`;
                        updateUrl = `{{ route('project.update-comment') }}`;
                    }
    
                    // Fetch comment data
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire({
                                title: 'Yorumu Düzenle',
                                html: `
                                    <form id="edit-comment-form">
                                        <input type="hidden" name="id" value="${response.data.id}">
                                        <input type="hidden" name="type" value="${response.data.type}">
                                     
                                        <div class="form-group">
                                            <label for="comment">Yorumunuz</label>
                                            <textarea id="comment" name="comment" class="form-control" style="height:125px !important">${response.data.comment}</textarea>
                                        </div>
                                    </form>
                                `,
                                showCancelButton: true,
                                confirmButtonText: 'Güncelle',
                                cancelButtonText: 'İptal',
                                preConfirm: () => {
                                    // Submit the form data
                                    return new Promise((resolve) => {
                                        $.ajax({
                                            url: updateUrl,
                                            type: 'POST',
                                            data: $('#edit-comment-form').serialize(),
                                            success: function() {
                                                Swal.fire('Başarıyla Güncellendi. Admin onayına gönderildi.', '', 'success');
                                                location.reload(); // Reload the page to reflect changes
                                            },
                                            error: function() {
                                                Swal.fire('Hata', 'Yorum güncellenirken bir hata oluştu', 'error');
                                            }
                                        });
                                    });
                                }
                            });
                        },
                        error: function() {
                            Swal.fire('Hata', 'Yorum alınırken bir hata oluştu', 'error');
                        }
                    });
                });
            }
    
            handleEditButtonClick(); // Initialize click event
        });
    </script>
    
@endsection


@section('styles')
    <style>
        .project-table-content ul li {
            flex: none !important;
        }

        .page-header-title2 {
            background: linear-gradient(to top, #EC2F2E, #84181A);
            padding: 10px;
            font-size: 18px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 40px;
        }

        .text-header {
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 18px;
        }

        .search-input {
            width: 21%;
            margin-top: 8px;
            /* border: #757575 !important; */
        }

        .form-control {
            border: 1px solid rgb(199 198 198) !important;
        }

        .edit-button:hover{
            background: white !important;
            border: 1px solid #ffc107;
            color: #ffc107;
        }
    </style>
@endsection
