@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="d-flex align-items-center justify-content-between my-3">
                            <h2 class="mb-2 lh-sm">Mağaza Bannerleri</h2>

                            <a class="btn btn-phoenix-success btn-sm" href="{{ route('institutional.storeBanners.create') }}">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="ms-1">Yeni Banner Ekle</span>
                            </a>
                        </div>
                        <p class="text-muted"><i class="fas fa-arrows-alt me-2"></i>Bannerleri sürükleyip yeniden sıralamak için
                            sürükleme işlevini kullanabilirsiniz.</p>

                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success text-white text-white">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    <div id="grid-container" class="row">
                                        @foreach ($storeBanners as $key => $banner)
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 grid-item" style="cursor: move;"
                                                data-banner-id="{{ $banner->id }}">
                                                <div class="card mb-3">
                                                    <img src="{{ asset('storage/store_banners/' . $banner->image) }}"
                                                        class="card-img-top" alt="Banner Resmi">
                                                    <div class="card-body">
                                                        <a href="{{ route('institutional.storeBanners.edit', $banner->id) }}"
                                                            class="btn btn-sm btn-primary btn-block">Güncelle</a>

                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal{{ $banner->id }}">
                                                            Sil
                                                        </button>

                                                        <!-- Silme işlemi için modal -->
                                                        <div class="modal fade" id="deleteModal{{ $banner->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="deleteModalLabel{{ $banner->id }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="deleteModalLabel{{ $banner->id }}">
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
                                                                            action="{{ route('institutional.storeBanners.destroy', $banner->id) }}"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
