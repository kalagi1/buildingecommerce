@extends('client.layouts.masterPanel')

@section('content')
<div class="table-breadcrumb">
    <ul>
        <li>
            Hesabım
        </li>
        <li>
            Reklam Görselleri ({{count($storeBanners)}})
        </li>
    </ul>   
</div>
<section>
    <div class="container p-0 m-0">
        <div class="alert alert-info" role="alert">
            Görsellerin sırasını değiştirmek için sürükle-bırak yapabilirsiniz. Reklam görselleriniz mağazanızda belirlediğiniz sırada görünecektir.
        </div>
        <div id="grid-container" class="row">
            @foreach ($storeBanners as $key => $banner)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 grid-item" style="cursor: move;"
                    data-banner-id="{{ hash_id($banner->id)}}">
                    <div class="card mb-3">
                        <img src="{{ asset('storage/store_banners/' . $banner->image) }}"
                            class="card-img-top" alt="Banner Resmi">
                        <div class="card-body">
                            <a href="{{ route('institutional.storeBanners.edit', hash_id($banner->id)) }}"
                                class="btn btn-sm btn-primary"><svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg></a>

                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ hash_id($banner->id) }}">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>

                            <!-- Silme işlemi için modal -->
                            <div class="modal fade" id="deleteModal{{ hash_id($banner->id) }}"
                                tabindex="-1"
                                aria-labelledby="deleteModalLabel{{ hash_id($banner->id) }}"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="deleteModalLabel{{ hash_id($banner->id) }}">
                                                Sil
                                            </h5>
                                            <button type="button" class="btn p-1"
                                                data-bs-dismiss="modal" aria-label="Close">
                                                <svg class="svg-inline--fa fa-xmark fs--1"
                                                    aria-hidden="true" focusable="false"
                                                    data-prefix="fas" data-icon="xmark"
                                                    banner="img"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 320 512" data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                                    </path>
                                                </svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com -->
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-700 lh-lg mb-0">Silmek
                                                istediğinize emin
                                                misiniz ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form
                                                action="{{ route('institutional.storeBanners.destroy', hash_id($banner->id)) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-danger">Evet,
                                                    Sil</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">İptal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#grid-container").sortable({
                update: function(event, ui) {
                    // Sıra değiştiğinde bu işlev çalışır
                    var order = [];
                    $("#grid-container .grid-item").each(function() {
                        order.push($(this).data('banner-id'));
                    });

                    // Sıra değişikliklerini sunucuya gönderin
                    $.ajax({
                        url: "{{ route('institutional.storeBanners.updateOrder') }}",
                        type: "POST",
                        data: {
                            _token: '{{ csrf_token() }}',
                            order: order
                        },
                        success: function(response) {
                            if (response.success) {
                                toastr.success("Sıralama başarıyla güncellendi");

                            } else {
                                // Hata mesajını göster
                            }
                        },
                        error: function(xhr, status, error) {
                            // Hata mesajını göster
                        }
                    });
                }
            });
            $('body').on('click', '.delete-banner', function(e) {
                e.preventDefault();
                var bannerId = $(this).data('banner-id');
                var deleteUrl = "{{ route('institutional.storeBanners.destroy', ':bannerId') }}".replace(
                    ':bannerId', bannerId);

                Swal.fire({
                    title: 'Emin misiniz?',
                    text: 'Bu bannerı silmek istediğinizden emin misiniz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Evet, Sil',
                    cancelButtonText: 'İptal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: deleteUrl,
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE',
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire('Başarılı!', 'Banner başarıyla silindi.',
                                        'success').then(function() {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire('Hata!',
                                        'Banner silinirken bir hata oluştu.',
                                        'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire('Hata!', 'Banner silinirken bir hata oluştu.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
