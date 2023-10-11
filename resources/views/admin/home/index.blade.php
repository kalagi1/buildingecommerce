@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="pb-5">
            <div class="row g-4">
                <div class="col-12 col-xxl-6">
                    <div class="mb-8">
                        <h2 class="mb-2">EMLAK SEPETİ YÖNETİM PANELİ</h2>
                    </div>
                    <div class="row align-items-center g-4">
                        <div class="col-12 col-md-auto">
                            <div class="d-flex align-items-center"><span class="fa-stack"
                                    style="min-height: 46px;min-width: 46px;"><span
                                        class="fa-solid fa-square fa-stack-2x text-success-300"
                                        data-fa-transform="down-4 rotate--10 left-4"></span><span
                                        class="fa-solid fa-circle fa-stack-2x stack-circle text-success-100"
                                        data-fa-transform="up-4 right-3 grow-2"></span><span
                                        class="fa-stack-1x fa-solid fa-star text-success "
                                        data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                <div class="ms-3">
                                    <h4 class="mb-0">{{ count($institutionals) }} Hesap</h4>
                                    <p class="text-800 fs--1 mb-0">Kurumsal Hesap</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <div class="d-flex align-items-center"><span class="fa-stack"
                                    style="min-height: 46px;min-width: 46px;"><span
                                        class="fa-solid fa-square fa-stack-2x text-warning-300"
                                        data-fa-transform="down-4 rotate--10 left-4"></span><span
                                        class="fa-solid fa-circle fa-stack-2x stack-circle text-warning-100"
                                        data-fa-transform="up-4 right-3 grow-2"></span><span
                                        class="fa-stack-1x fa-solid fa-pause text-warning "
                                        data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                <div class="ms-3">
                                    <h4 class="mb-0">{{ count($clients) }} Hesap</h4>
                                    <p class="text-800 fs--1 mb-0">Bireysel Hesap</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-auto">
                            <div class="d-flex align-items-center"><span class="fa-stack"
                                    style="min-height: 46px;min-width: 46px;"><span
                                        class="fa-solid fa-square fa-stack-2x text-danger-300"
                                        data-fa-transform="down-4 rotate--10 left-4"></span><span
                                        class="fa-solid fa-circle fa-stack-2x stack-circle text-danger-100"
                                        data-fa-transform="up-4 right-3 grow-2"></span><span
                                        class="fa-stack-1x fa-solid fa-xmark text-danger "
                                        data-fa-transform="shrink-2 up-8 right-6"></span></span>
                                <div class="ms-3">
                                    <h4 class="mb-0">{{ count($projects) }} Proje</h4>
                                    <p class="text-800 fs--1 mb-0">Proje Sayısı</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="bg-200 mb-6 mt-4" />
                    <div class="row flex-between-center mb-4 g-3">
                        <div class="col-auto">
                            <h3>İlan Paylaşımı</h3>
                            <p class="text-700 lh-sm mb-0">İstatistiği görüntüleyebilirsiniz.</p>
                        </div>
                        <div class="col-8 col-sm-4"><select class="form-select form-select-sm mt-2"
                                id="select-gross-revenue-month">
                                <option>Mar 1 - 31, 2022</option>
                                <option>April 1 - 30, 2022</option>
                                <option>May 1 - 31, 2022</option>
                            </select></div>
                    </div>
                    <div class="echart-total-sales-chart" style="min-height:320px;width:100%"></div>
                </div>
                <div class="col-12 col-xxl-6">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Total orders<span
                                                    class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"><span
                                                        class="badge-label">-6.8%</span></span></h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                        <h4>16,247</h4>
                                    </div>
                                    <div class="d-flex justify-content-center px-4 py-6">
                                        <div class="echart-total-orders" style="height:85px;width:115px"></div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Completed</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">52%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-primary-100 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Pending payment</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">48%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">New customers<span
                                                    class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2">
                                                    <span class="badge-label">+26.5%</span></span></h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                        <h4>356</h4>
                                    </div>
                                    <div class="pb-0 pt-4">
                                        <div class="echarts-new-customers" style="height:180px;width:100%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-2">Top coupons</h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                    </div>
                                    <div class="pb-4 pt-3">
                                        <div class="echart-top-coupons" style="height:115px;width:100%;"></div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Percentage discount</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">72%</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary-200 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Fixed card discount</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">18%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-info-500 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Fixed product discount</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">10%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-2">Paying vs non paying</h5>
                                            <h6 class="text-700">Last 7 days</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center pt-3 flex-1">
                                        <div class="echarts-paying-customer-chart" style="height:100%;width:100%;"></div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Paying customer</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">30%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-primary-100 me-2"></div>
                                            <h6 class="text-900 fw-semi-bold flex-1 mb-0">Non-paying customer</h6>
                                            <h6 class="text-900 fw-semi-bold mb-0">70%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-7 border-y border-300">
            <div data-list='{"valueNames":["product","customer","rating","review","time"],"page":4}'>
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
                                <th class="sort white-space-nowrap align-middle" scope="col" style="min-width: 200px;"
                                    data-sort="product">Üye</th>
                                <th class="sort align-middle" scope="col" data-sort="customer"
                                    style="min-width: 200px;">Yorum</th>
                                <th class="sort align-middle" scope="col" data-sort="rating"
                                    style="min-width: 110px;">Oylama</th>

                                <th class="sort text-start ps-5 align-middle" scope="col" data-sort="status">Durum
                                </th>
                                <th class="sort align-middle" scope="col" colspan="2" data-sort="review">Tarih
                                </th>
                            </tr>
                        </thead>
                        <tbody class="list" id="table-latest-review-body">
                            @foreach ($comments as $key => $comment)
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
                                                <span data-feather="x" style="height: 12.8px; width: 12.8px;"></span>

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
                                                aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
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
                        <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info"></p>
                        <a class="fw-semi-bold" href="{{ route('admin.housings.comments') }}" data-list-view="*">Tümünü
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

        <div class="row gx-6">
            <div class="col-12 col-xl-6">
                <div data-list='{"valueNames":["country","users","transactions","revenue","conv-rate"],"page":5}'>
                    <div class="mb-5 mt-7">
                        <h3>Top regions by revenue</h3>
                        <p class="text-700">Where you generated most of the revenue</p>
                    </div>
                    <div class="table-responsive scrollbar">
                        <table class="table fs--2 mb-0">
                            <thead>
                                <tr>
                                    <th class="sort border-top border-200 ps-0 align-middle" scope="col"
                                        data-sort="country" style="width:32%">COUNTRY</th>
                                    <th class="sort border-top border-200 align-middle" scope="col" data-sort="users"
                                        style="width:17%">USERS</th>
                                    <th class="sort border-top border-200 text-end align-middle" scope="col"
                                        data-sort="transactions" style="width:16%">TRANSACTIONS</th>
                                    <th class="sort border-top border-200 text-end align-middle" scope="col"
                                        data-sort="revenue" style="width:20%">REVENUE</th>
                                    <th class="sort border-top border-200 text-end pe-0 align-middle" scope="col"
                                        data-sort="conv-rate" style="width:17%">CONV. RATE</th>
                                </tr>
                            </thead>
                            <tr>
                                <td></td>
                                <td class="align-middle py-4">
                                    <h4 class="mb-0 fw-normal">377,620</h4>
                                </td>
                                <td class="align-middle text-end py-4">
                                    <h4 class="mb-0 fw-normal">236</h4>
                                </td>
                                <td class="align-middle text-end py-4">
                                    <h4 class="mb-0 fw-normal">$15,758</h4>
                                </td>
                                <td class="align-middle text-end py-4 pe-0">
                                    <h4 class="mb-0 fw-normal">10.32%</h4>
                                </td>
                            </tr>
                            <tbody class="list" id="table-regions-by-revenue">
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">1. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/india.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">India</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">92896<span class="text-700 fw-semi-bold ms-2">(41.6%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">67<span class="text-700 fw-semi-bold ms-2">(34.3%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$7560<span class="text-700 fw-semi-bold ms-2">(36.9%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>14.01%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">2. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/china.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">China</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">50496<span class="text-700 fw-semi-bold ms-2">(32.8%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">54<span class="text-700 fw-semi-bold ms-2">(23.8%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$6532<span class="text-700 fw-semi-bold ms-2">(26.5%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>23.56%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">3. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/usa.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">USA</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">45679<span class="text-700 fw-semi-bold ms-2">(24.3%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">35<span class="text-700 fw-semi-bold ms-2">(19.7%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$5432<span class="text-700 fw-semi-bold ms-2">(16.9%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>10.23%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">4. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/south-korea.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">South Korea</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">36453<span class="text-700 fw-semi-bold ms-2">(19.7%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">22<span class="text-700 fw-semi-bold ms-2">(9.54%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$4673<span class="text-700 fw-semi-bold ms-2">(11.6%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>8.85%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">5. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/vietnam.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">Vietnam</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">15007<span class="text-700 fw-semi-bold ms-2">(11.9%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">17<span class="text-700 fw-semi-bold ms-2">(6.91%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$2456<span class="text-700 fw-semi-bold ms-2">(10.2%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>6.01%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">6. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/russia.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">Russia</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">54215<span class="text-700 fw-semi-bold ms-2">(32.9%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">38<span class="text-700 fw-semi-bold ms-2">(7.91%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$3254<span class="text-700 fw-semi-bold ms-2">(12.4%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>6.21%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">7. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/australia.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">Australia</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">54789<span class="text-700 fw-semi-bold ms-2">(12.7%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">32<span class="text-700 fw-semi-bold ms-2">(14.0%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$3215<span class="text-700 fw-semi-bold ms-2">(5.72%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>12.02%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">8. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/england.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">England</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">14785<span class="text-700 fw-semi-bold ms-2">(12.9%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">11<span class="text-700 fw-semi-bold ms-2">(32.91%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$4745<span class="text-700 fw-semi-bold ms-2">(10.2%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>8.01%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">9. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/indonesia.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">Indonesia</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">32156<span class="text-700 fw-semi-bold ms-2">(32.2%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">89<span class="text-700 fw-semi-bold ms-2">(12.0%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$2456<span class="text-700 fw-semi-bold ms-2">(23.2%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>9.07%</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="white-space-nowrap ps-0 country" style="width:32%">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-3">10. </h6><a href="#!">
                                                <div class="d-flex align-items-center"><img
                                                        src="{{ URL::to('/') }}/adminassets/assets/img/country/japan.png"
                                                        alt="" width="24" />
                                                    <p class="mb-0 ps-3 text-primary fw-bold fs--1">Japan</p>
                                                </div>
                                            </a>
                                        </div>
                                    </td>
                                    <td class="align-middle users" style="width:17%">
                                        <h6 class="mb-0">12547<span class="text-700 fw-semi-bold ms-2">(12.7%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end transactions" style="width:17%">
                                        <h6 class="mb-0">21<span class="text-700 fw-semi-bold ms-2">(14.91%)</span></h6>
                                    </td>
                                    <td class="align-middle text-end revenue" style="width:17%">
                                        <h6 class="mb-0">$2541<span class="text-700 fw-semi-bold ms-2">(23.2%)</span>
                                        </h6>
                                    </td>
                                    <td class="align-middle text-end pe-0 conv-rate" style="width:17%">
                                        <h6>20.01%</h6>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row align-items-center py-1">
                        <div class="pagination d-none"></div>
                        <div class="col d-flex fs--1">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semi-bold text-900" data-list-info="data-list-info">
                            </p>
                        </div>
                        <div class="col-auto d-flex">
                            <button class="btn btn-link px-1 me-1" type="button" title="Previous"
                                data-list-pagination="prev"><span
                                    class="fas fa-chevron-left me-2"></span>Previous</button><button
                                class="btn btn-link px-1 ms-1" type="button" title="Next"
                                data-list-pagination="next">Next<span class="fas fa-chevron-right ms-2"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6">
                <div class="mx-n4 mx-lg-n6 ms-xl-0 h-100">
                    <div class="h-100 w-100">
                        <div class="h-100 bg-white" id="map" style="min-height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white pt-6 pb-9 border-top border-300">
            <div class="row g-6">
                <div class="col-12 col-xl-6">
                    <div class="me-xl-4">
                        <div>
                            <h3>Projection vs actual</h3>
                            <p class="mb-1 text-700">Actual earnings vs projected earnings</p>
                        </div>
                        <div class="echart-projection-actual" style="height:300px; width:100%"></div>
                    </div>
                </div>
                <div class="col-12 col-xl-6">
                    <div>
                        <h3>Returning customer rate</h3>
                        <p class="mb-1 text-700">Rate of customers returning to your shop over time</p>
                    </div>
                    <div class="echart-returning-customer" style="height:300px;"></div>
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
