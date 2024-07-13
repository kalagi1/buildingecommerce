@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row g-4">
            <div class="col-12 col-xl-12  order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 my-4 p-5">
                        <div class="row align-items-end justify-content-between pb-5 g-3">
                            <div class="col-auto">
                                <h3>Değerlendirmeler</h3>
                            </div>
                        </div>
                        <div class="table-responsive mx-n1 px-1 scrollbar">
                            <table class="table fs--1 mb-0 border-top border-200">
                                <thead>
                                    <tr>
                                        <th class="sort white-space-nowrap align-middle" scope="col">No.</th>
                                        <th class="sort white-space-nowrap align-middle" scope="col"
                                            style="min-width: 200px;" data-sort="product">Üye</th>
                                        <th class="sort align-middle" scope="col" data-sort="customer"
                                            style="min-width: 200px;">
                                            Yorum</th>

                                        <th class="sort align-middle" scope="col" data-sort="rating"
                                            style="min-width: 110px;">
                                            Oylama</th>

                                        <th class="sort align-middle" scope="col" data-sort="customer"
                                            style="min-width: 200px;">
                                            İlan Numarası</th>


                                        <th class="sort text-start ps-5 align-middle" scope="col" data-sort="status">
                                            Durum
                                        </th>
                                        <th class="sort align-middle" scope="col" colspan="2" data-sort="review">Tarih
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="list" id="table-latest-review-body">
                                    @foreach ($housing as $key => $comment)
                                        <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                            <td class="align-middle product white-space-nowrap py-0">
                                                {{ $key + 1 }}
                                            </td>
                                            <td class="align-middle customer white-space-nowrap">
                                                <a class="d-flex align-items-center text-900">
                                                    <div class="avatar avatar-l">
                                                        <img class="rounded-circle"
                                                            src="{{ URL::to('/') }}/storage/profile_images/{{ $comment->user->profile_image }}"
                                                            alt="" />
                                                    </div>
                                                    <h6 class="mb-0 ms-3 text-900">{{ $comment->user->name }}</h6>
                                                </a>
                                            </td>
                                            <td class="align-middle review" style="min-width: 350px;">
                                                <p class="fs--1 fw-semi-bold text-1000 mb-0">{{ $comment->comment }}</p>
                                                <div class="row mt-3">
                                                    @foreach (json_decode($comment->images, true) as $img)
                                                        <div class="col-md-2">
                                                            <a href="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                                data-lightbox="gallery">
                                                                <img src="<?= asset('storage/' . preg_replace('@^public/@', null, $img)) ?>"
                                                                    style="object-fit: cover;width:100%" />
                                                            </a>

                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="align-middle rating white-space-nowrap fs--2">
                                                @for ($i = 0; $i < $comment->rate; $i++)
                                                    <svg viewBox="0 0 14 14" class="widget-svg"
                                                        style="width: 10.89px; height: 10.89px; transition: transform 0.2s ease-in-out 0s;">
                                                        <path class="star"
                                                            d="M13.668 5.014a.41.41 0 0 1 .21.695l-3.15 3.235.756 4.53a.4.4 0 0 1-.376.5.382.382 0 0 1-.179-.046l-3.91-2.14-3.9 2.164a.372.372 0 0 1-.408-.03.41.41 0 0 1-.155-.397l.733-4.557-3.17-3.217a.415.415 0 0 1-.1-.415.396.396 0 0 1 .313-.277l4.368-.68L6.64.229A.386.386 0 0 1 6.986 0c.146 0 .281.087.348.226L9.3 4.364l4.368.65z"
                                                            style="fill: rgb(255, 192, 0); transition: fill 0.2s ease-in-out 0s;">
                                                        </path>
                                                    </svg>
                                                @endfor
                                            </td>

                                            <td class="align-middle">                        
                                                <a href="{{  route('housing.show', ['housingSlug' => $comment->housing->slug, 'housingID' => $comment->housing->id + 2000000])}}"> {{$comment->housing->id + 2000000}} </a>
                                            </td>
                                              

                                            <td class="align-middle text-start ps-5 status">
                                                @if ($comment->status == '1')
                                                    <span class="badge badge-phoenix fs--2 badge-phoenix-success">
                                                        <span class="badge-label">Aktif</span>
                                                        <span class="ms-1" data-feather="check"
                                                            style="height: 12.8px; width: 12.8px;"></span>
                                                    </span>
                                                @else
                                                    <span class="badge badge-phoenix fs--2 badge-phoenix-danger">
                                                        <span class="badge-label">Pasif</span>
                                                        <span data-feather="x"
                                                            style="height: 12.8px; width: 12.8px;"></span>

                                                    </span>
                                                @endif

                                            </td>
                                            <td class="align-middle text-end time white-space-nowrap">
                                                <div class="hover-hide">
                                                    <h6 class="text-1000 mb-0">
                                                        {{ $comment->created_at->locale('tr')->isoFormat('D MMM, HH:mm') }}
                                                    </h6>
                                                </div>
                                            </td>


                                            <td class="align-middle white-space-nowrap text-end pe-0">
                                                <div class="position-relative">
                                                    <div class="hover-actions">
                                                        @if ($comment->status)
                                                            <a class="btn btn-sm btn-phoenix-secondary me-1 fs--2"
                                                                href="{{ route('admin.housings.unapprove', $comment->id) }}"><span
                                                                    class="fas fa-cancel"></span>
                                                                Kaldır</a>
                                                        @else
                                                            <a class="btn btn-sm btn-phoenix-secondary fs--2"
                                                                href="{{ route('admin.housings.approve', $comment->id) }}"><span
                                                                    class="fas fa-check"></span>
                                                                Yayında</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="font-sans-serif btn-reveal-trigger position-static">
                                                    <button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
                                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                        aria-haspopup="true" aria-expanded="false"
                                                        data-bs-reference="parent">
                                                        <span class="fas fa-ellipsis-h fs--2"></span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row align-items-center py-1">
                            <div class="pagination d-none"></div>
                            <div class="col d-flex fs--1">
                                <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900"
                                    data-list-info="data-list-info"></p>
                                <a class="fw-semi-bold" href="{{ route('admin.housings.comments') }}"
                                    data-list-view="*">Tümünü
                                    Görüntüle<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>

                            </div>
                            <div class="col-auto d-flex">
                                <button class="btn btn-link px-1 me-1" type="button" title="Previous"
                                    data-list-pagination="prev">
                                    <span class="fas fa-chevron-left me-2"></span>Geri
                                </button>
                                <button class="btn btn-link px-1 ms-1" type="button" title="Next"
                                    data-list-pagination="next">
                                    İleri<span class="fas fa-chevron-right ms-2"></span>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <!-- lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- lightbox2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endsection
