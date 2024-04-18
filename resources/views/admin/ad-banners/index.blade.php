@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="mb-9">
                <div id="adBannerList"
                    data-list='{"valueNames":["id","image","background_color","link","action"],"page":12,"pagination":true}'>
                    <div class="row justify-content-between mb-4 gx-6 gy-3 align-items-center">
                        <div class="col-auto">
                            <h3 class="mb-0">Reklam Bannerları<span
                                    class="fw-normal text-700 ms-3">({{ count($adBanners) }})</span></h2>
                        </div>
                        <div class="col-auto">
                            <div class="col-auto"><a class="btn btn-primary px-5"
                                    href="{{ route('admin.adBanners.create') }}"><i class="fa-solid fa-plus me-2"></i>Yeni
                                    Ekle</a></div>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success text-white text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-white text-white">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card shadow-none border border-300 my-4 p-5">
                        <div class="table-responsive scrollbar">
                            <table class="table fs--1 mb-0 border-top border-200">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">ID</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="image">Görsel</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="background_color">Arkaplan Rengi</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="background_color">Aktif/Pasif</th>
                                        <th class="sort white-space-nowrap align-middle ps-0" scope="col"
                                            data-sort="link">Link</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="adBanner-list-table-body">
                                    @foreach ($adBanners as $adBanner)
                                        <tr class="position-static">
                                            <td>{{ $adBanner->id }}</td>
                                            <td>
                                                <img src="{{ url('storage/' . $adBanner->image) }}"
                                                    alt="Görsel" style="width: 100px">
                                            </td>
                                            <td style="background: {{ $adBanner->background_color }};color:white">{{ $adBanner->background_color }}</td>
                                            <td>
                                                @if ($adBanner->is_visible)
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-danger">Pasif</span>
                                                @endif
                                            </td>
                                            <td>{{ $adBanner->link }}</td>
                                            <td>
                                                <a href="{{ route('admin.adBanners.edit', $adBanner->id) }}"
                                                    class="btn btn-sm btn-primary">Düzenle</a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $adBanner->id }}">Sil</button>

                                                <!-- Silme işlemi için modal -->
                                                <div class="modal fade" id="deleteModal{{ $adBanner->id }}" tabindex="-1"
                                                    aria-labelledby="deleteModalLabel{{ $adBanner->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="deleteModalLabel{{ $adBanner->id }}">Sil</h5>
                                                                <button type="button" class="btn p-1"
                                                                    data-bs-dismiss="modal" aria-label="Close">
                                                                    <svg class="svg-inline--fa fa-xmark fs--1"
                                                                        aria-hidden="true" focusable="false"
                                                                        data-prefix="fas" data-icon="xmark" page="img"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 320 512" data-fa-i2svg="">
                                                                        <path fill="currentColor"
                                                                            d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z">
                                                                        </path>
                                                                    </svg><!-- <span class="fas fa-times fs--1"></span> Font Awesome fontawesome.com -->
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p class="text-700 lh-lg mb-0">Silmek istediğinize emin
                                                                    misiniz ?</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form
                                                                    action="{{ route('admin.adBanners.destroy', $adBanner->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">Evet,
                                                                        Sil</button>
                                                                </form>
                                                                <button type="button" class="btn btn-secondary"
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
                        <div
                            class="d-flex flex-wrap align-items-center justify-content-between py-3 pe-0 fs--1 border-bottom border-200">
                            <div class="d-flex">
                                <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                    data-list-info="data-list-info"></p>
                            </div>
                            <div class="d-flex">
                                <button class="page-link" data-list-pagination="prev"><span
                                        class="fas fa-chevron-left"></span></button>
                                <ul class="mb-0 pagination"></ul>
                                <button class="page-link pe-0" data-list-pagination="next"><span
                                        class="fas fa-chevron-right"></span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
