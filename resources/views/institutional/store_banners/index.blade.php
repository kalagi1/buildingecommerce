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
                                                        <th>İşlemler</th>
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
                                                                <div
                                                                    class="font-sans-serif btn-reveal-trigger position-static">
                                                                    <button
                                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                                                        type="button" data-bs-toggle="dropdown"
                                                                        data-bs-boundary="window" aria-haspopup="true"
                                                                        aria-expanded="false" data-bs-reference="parent">
                                                                        <span class="fas fa-ellipsis-h fs--2"></span>
                                                                    </button>
                                                                    <div class="dropdown-menu dropdown-menu py-2">
                                                                        <a class="dropdown-item"
                                                                            href="{{ route('institutional.storeBanners.edit', $banner->id) }}">Düzenle</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item text-danger delete-banner"
                                                                            href="#"
                                                                            data-banner-id="{{ $banner->id }}">Sil</a>
                                                                    </div>
                                                                </div>
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
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div>
                    <button class="btn-close btn-close-white me-2 m-auto" type="button" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br
                            class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v1.13.0</p>
                </div>
            </div>
        </footer>
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
