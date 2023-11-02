@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Mağaza Bannerleri</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div class="d-flex align-items-center justify-content-end my-3">
                                        <div id="bulk-select-replace-element">
                                            <a class="btn btn-phoenix-success btn-sm"
                                                href="{{ route('institutional.storeBanners.create') }}">
                                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                                <span class="ms-1">Yeni Banner Ekle</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        @if (session()->has('success'))
                                            <div class="alert alert-success text-white">
                                                {{ session()->get('success') }}
                                            </div>
                                        @endif
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="white-space-nowrap fs--1 align-middle ps-0">
                                                            #
                                                        </th>
                                                        <th>Banner Resmi</th>
                                                        <th style="width: 200px">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="bulk-select-body">
                                                    @foreach ($storeBanners as $key => $banner)
                                                        <tr>
                                                            <td>
                                                                {{ $key + 1 }}
                                                            </td>
                                                            <td>
                                                                <img src="{{ asset('storage/store_banners/' . $banner->image) }}"
                                                                    alt="Banner Resmi" width="100">
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('institutional.storeBanners.edit', $banner->id) }}"
                                                                    class="btn btn-sm btn-primary">Güncelle</a>

                                                                <!-- Silme işlemi için modal -->
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
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close">
                                                                                    <svg class="svg-inline--fa fa-xmark fs--1"
                                                                                        aria-hidden="true" focusable="false"
                                                                                        data-prefix="fas" data-icon="xmark"
                                                                                        banner="img"
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        viewBox="0 0 320 512"
                                                                                        data-fa-i2svg="">
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
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">İptal</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Silme işlemi için modal -->
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="d-flex flex-between-center pt-3 mb-3">
                                            <div class="pagination d-none"></div>
                                            <p class="mb-0 fs--1">
                                                <span class="d-none d-sm-inline-block"
                                                    data-list-info="data-list-info"></span>
                                                <span class="d-none d-sm-inline-block"> &mdash; </span>
                                                <a class="fw-semi-bold" href="#!" data-list-view="*">
                                                    View all
                                                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                                </a>
                                                <a class="fw-semi-bold d-none" href="#!" data-list-view="less">
                                                    View Less
                                                    <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                                                </a>
                                            </p>
                                            <div class="d-flex">
                                                <button class="btn btn-sm btn-primary" type="button"
                                                    data-list-pagination="prev"><span>Previous</span></button>
                                                <button class="btn btn-sm btn-primary px-4 ms-2" type="button"
                                                    data-list-pagination="next"><span>Next</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" banner="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div>
                    <button class="btn-close btn-close-white me-2 m-auto" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store Banner'ı silme işlemi
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
