@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="d-flex mb-5 " id="scrollspyStats">

            <div class="col">
                <h3 class="mb-0 text-primary position-relative fw-bold"><span class="bg-soft pe-2">
                        <span class="bg-soft pe-2">
                            Emlak Sepette Yönetim Paneli
                        </span>
                    </span><span
                        class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                </h3>
                <p class="mb-0">Bu alanda istatistik içeriklerinizi kolaylıkla görüntüleyebilirsiniz.</p>
            </div>
        </div>
        <div class="row gy-3 mb-6 justify-content-between">
            <div class="px-3 mb-5">
                <div class="row justify-content-between">
                    <div
                        class="col-6 col-md-4 col-xxl-2 text-center border-start-xxl border-end-xxl-0 border-bottom-xxl-0 border-end border-bottom pb-4 pb-xxl-0 ">
                        <span class="uil fs-3 lh-1 uil-user text-primary"></span>
                        <h1 class="fs-3 pt-3">{{ count($institutionals) }}</h1>
                        <p class="fs--1 mb-0">Aktif Mağaza Sayısı</p>
                    </div>
                    <div
                        class="col-6 col-md-4 col-xxl-2 text-center border-start-xxl border-bottom-xxl-0 border-bottom border-end border-end-md-0 pb-4 pb-xxl-0 pt-4 pt-md-0">
                        <span class="uil fs-3 lh-1 uil-home text-primary"></span>
                        <h1 class="fs-3 pt-3">{{ count($projects) }}</h1>
                        <p class="fs--1 mb-0">Aktif Proje Sayısı</p>
                    </div>
                    <div
                        class="col-6 col-md-4 col-xxl-2 text-center border-start-xxl border-end-xxl-0 border-bottom-xxl-0 border-end-md border-bottom pb-4 pb-xxl-0">
                        <span class="uil fs-3 lh-1 uil-envelope-upload text-info"></span>
                        <h1 class="fs-3 pt-3">1,866</h1>
                        <p class="fs--1 mb-0">Emails Sent</p>
                    </div>

                    <div
                        class="col-6 col-md-4 col-xxl-2 text-center border-start-xxl border-end-md border-end-xxl-0 border-bottom border-bottom-md-0 pb-4 pb-xxl-0 pt-4 pt-xxl-0">
                        <span class="uil fs-3 lh-1 uil-envelope-open text-info"></span>
                        <h1 class="fs-3 pt-3">1,200</h1>
                        <p class="fs--1 mb-0">Emails Opened</p>
                    </div>
                    <div
                        class="col-6 col-md-4 col-xxl-2 text-center border-start-xxl border-end border-end-xxl-0 pb-md-4 pb-xxl-0 pt-4 pt-xxl-0">
                        <span class="uil fs-3 lh-1 uil-envelope-check text-success"></span>
                        <h1 class="fs-3 pt-3">900</h1>
                        <p class="fs--1 mb-0">Emails Clicked</p>
                    </div>
                    <div
                        class="col-6 col-md-4 col-xxl-2 text-center border-start-xxl border-end-xxl pb-md-4 pb-xxl-0 pt-4 pt-xxl-0">
                        <span class="uil fs-3 lh-1 uil-envelope-block text-danger"></span>
                        <h1 class="fs-3 pt-3">500</h1>
                        <p class="fs--1 mb-0">Emails Bounce</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-5">
            <div class="row g-4">
                <div class="col-md-6 col-xxl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="mb-1">Toplam Proje Sayısı<span
                                            class="badge badge-phoenix badge-phoenix-warning rounded-pill fs--1 ms-2"><span
                                                class="badge-label">-6.8%</span></span></h5>
                                    <h6 class="text-700">Son 7 gün</h6>
                                </div>
                                <h4>{{ count($projects) + count($passiveProjects) }}</h4>
                            </div>
                            <div class="d-flex justify-content-center px-4 py-6">
                                <div class="echart-total-orders" style="height:85px;width:115px"></div>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="bullet-item bg-primary me-2"></div>
                                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Aktif</h6>
                                    <h6 class="text-900 fw-semi-bold mb-0">{{ count($projects) }}</h6>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bullet-item bg-primary-100 me-2"></div>
                                    <h6 class="text-900 fw-semi-bold flex-1 mb-0">Pasif</h6>
                                    <h6 class="text-900 fw-semi-bold mb-0">{{ count($passiveProjects) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xxl-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="card-title mb-5">
                                <h3 class="text-1100">Son Eklenen Projeler</h3>
                            </div>
                            <div class="timeline-vertical timeline-with-details">
                                @php
                                    $projectCount = count($descProjects);

                                @endphp
                                @foreach ($descProjects as $key => $project)
                                    <div class="timeline-item position-relative">
                                        <div class="row g-md-3">
                                            <div class="col-12 col-md-auto d-flex">
                                                <div class="timeline-item-date order-1 order-md-0 me-md-4">
                                                    <p class="fs--2 fw-semi-bold text-600 text-end">
                                                        <strong> {{ $key + 1 }}</strong>
                                                    </p>
                                                </div>
                                                <div class="timeline-item-bar position-md-relative me-3 me-md-0 border-400">
                                                    <div
                                                        class="icon-item icon-item-sm rounded-7 shadow-none bg-primary-100">
                                                        <svg class="svg-inline--fa fa-home text-primary-600 fs--2 dark__text-primary-300"
                                                            aria-hidden="true" focusable="false" data-prefix="fas"
                                                            data-icon="home" role="img"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                            data-fa-i2svg="">
                                                            <path fill="currentColor"
                                                                d="M74.01 208h-10c-8.875 0-16 7.125-16 16v16c0 8.875 7.122 16 15.1 16h16c-.25 43.13-5.5 86.13-16 128h128c-10.5-41.88-15.75-84.88-16-128h15.1c8.875 0 16-7.125 16-16L208 224c0-8.875-7.122-16-15.1-16h-10l33.88-90.38C216.6 115.8 216.9 113.1 216.9 112.1C216.9 103.1 209.5 96 200.9 96H144V64h16c8.844 0 16-7.156 16-16S168.9 32 160 32h-16l.0033-16c0-8.844-7.16-16-16-16s-16 7.156-16 16V32H96.01c-8.844 0-16 7.156-16 16S87.16 64 96.01 64h16v32H55.13C46.63 96 39.07 102.8 39.07 111.9c0 1.93 .3516 3.865 1.061 5.711L74.01 208zM339.9 301.8L336.6 384h126.8l-3.25-82.25l24.5-20.75C491.9 274.9 496 266 496 256.5V198C496 194.6 493.4 192 489.1 192h-26.37c-3.375 0-6 2.625-6 6V224h-24.75V198C432.9 194.6 430.3 192 426.9 192h-53.75c-3.375 0-6 2.625-6 6V224h-24.75V198C342.4 194.6 339.8 192 336.4 192h-26.38C306.6 192 304 194.6 304 198v58.62c0 9.375 4.125 18.25 11.38 24.38L339.9 301.8zM384 304C384 295.1 391.1 288 400 288S416 295.1 416 304v32h-32V304zM247.1 459.6L224 448v-16C224 423.1 216.9 416 208 416h-160C39.13 416 32 423.1 32 432V448l-23.12 11.62C3.375 462.3 0 467.9 0 473.9V496C0 504.9 7.125 512 16 512h224c8.875 0 16-7.125 16-16v-22.12C256 467.9 252.6 462.3 247.1 459.6zM503.1 459.6L480 448v-16c0-8.875-7.125-16-16-16h-128c-8.875 0-16 7.125-16 16V448l-23.12 11.62C291.4 462.3 288 467.9 288 473.9V496c0 8.875 7.125 16 16 16h192c8.875 0 16-7.125 16-16v-22.12C512 467.9 508.6 462.3 503.1 459.6z">
                                                            </path>
                                                        </svg><!-- <span class="fa-solid fa-chess text-primary-600 fs--2 dark__text-primary-300"></span> Font Awesome fontawesome.com -->

                                                    </div>
                                                    <?php if ($key < $projectCount - 1) { ?>

                                                    <span class="timeline-bar border-end border-dashed border-400"></span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="timeline-item-content ps-6 ps-md-3">
                                                    <h5 class="fs--1 lh-sm">{{ $project->project_title }}
                                                    </h5>
                                                    <p class="fs--1">by <a target="_blank" class="fw-semi-bold"
                                                            href="{{ route('admin.projects.detail', Str::slug($project->id)) }}">{{ $project->user->name }}</a>
                                                    </p>
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
                                    style="min-width: 200px;">
                                    Yorum</th>
                                <th class="sort align-middle" scope="col" data-sort="rating"
                                    style="min-width: 110px;">
                                    Oylama</th>

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
                                                    style="fill: #e54242; transition: fill 0.2s ease-in-out 0s;">
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

    </div>
@endsection



@section('scripts')
    <!-- lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- lightbox2 JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Housing ve Project verilerini aldık
        var housingData = @json($secondhandHousings);
        var projectData = @json($projects);



        // Verileri aylara göre grupladık
        var housingMonthlyData = groupDataByMonth(housingData);
        var projectMonthlyData = groupDataByMonth(projectData);

        var ctx = document.getElementById('myChart').getContext('2d');

        var availableMonths = []; // Veri içeren ayları saklayacak dizi

        for (var monthKey in housingMonthlyData) {
            if (housingMonthlyData.hasOwnProperty(monthKey) || projectMonthlyData.hasOwnProperty(monthKey)) {
                availableMonths.push(monthKey);
            }
        }

        // Ayları Ocak'tan Aralık'a sıralı bir şekilde alarak liste oluşturduk
        var months = getMonthLabels(availableMonths);
        // Grafik için veri ve seçenekleri ayarladık
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Emlaklar',
                    data: getMonthlyCounts(housingMonthlyData, availableMonths),
                    borderColor: '#3c5a99',
                    borderWidth: 2,
                    pointRadius: 3, // Noktaları göster
                    fill: false,
                    lineTension: 0.3, // Bezier eğrisi ekle
                }, {
                    label: 'Projeler',
                    data: getMonthlyCounts(projectMonthlyData, availableMonths),
                    borderColor: '#1da1f2',
                    borderWidth: 2,
                    pointRadius: 3, // Noktaları göster
                    fill: false,
                    lineTension: 0.4, // Bezier eğrisi ekle
                    showLine: true // Projeler için çizgiyi gizle
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true // Seri etiketlerinde nokta simgesi kullan
                        }
                    },
                    annotation: {
                        annotations: {
                            customAnnotation: {
                                drawTime: 'afterDatasetsDraw',
                                type: 'line',
                                mode: 'vertical',
                                scaleID: 'x',
                                value: months.length - 1,
                                borderColor: 'black',
                                borderWidth: 2,
                                label: {
                                    content: 'Aralık',
                                    enabled: true,
                                    position: 'top'
                                }
                            }
                        }
                    }
                }
            }
        });


        // İndirilebilir görüntü oluştur
        var canvas = document.getElementById('myChart');
        var downloadLink = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
        var downloadButton = document.createElement('a');
        downloadButton.download = 'chart.png';
        downloadButton.href = downloadLink;
        downloadButton.innerHTML = 'Grafiği İndir';
        downloadButton.style.marginTop = '20px';
        document.body.appendChild(downloadButton);

        function groupDataByMonth(data) {
            var groupedData = {};
            data.forEach(function(item) {
                var date = new Date(item.created_at);
                var month = date.getMonth() + 1; // JavaScript'te aylar 0'dan başlar
                var year = date.getFullYear();
                var key = year + '-' + month;

                if (!groupedData[key]) {
                    groupedData[key] = 0;
                }

                groupedData[key]++;
            });

            return groupedData;
        }

        function getMonthLabels(availableMonths) {
            var months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim',
                'Kasım', 'Aralık'
            ];
            var availableMonthLabels = availableMonths.map(function(monthKey) {
                var parts = monthKey.split('-');
                return months[parseInt(parts[1]) - 1] + ' ' + parts[0];
            });
            return availableMonthLabels;
        }

        function getMonthlyCounts(data, availableMonths) {
            var monthlyCounts = [];
            availableMonths.forEach(function(monthKey) {
                monthlyCounts.push(data[monthKey] || 0);
            });
            return monthlyCounts;
        }
        // İndirme butonunu seç
        var downloadButton = document.getElementById('downloadButton');
        downloadButton.style.position = 'absolute'; // Butonun konumunu ayarla
        downloadButton.style.top = '-1px'; // Yatay konumu
        downloadButton.style.right = '40px'; // Dikey konumu

        // İndirme butonuna tıklanınca işlemi yap
        downloadButton.addEventListener('click', function() {
            // Grafiği indirme işlemi
            var canvas = document.getElementById('myChart');
            var downloadLink = canvas.toDataURL('image/png').replace('image/png', 'image/octet-stream');
            downloadButton.href = downloadLink;
        });
    </script>
@endsection


@section('css')
    <style>
        #downloadButton {
            cursor: pointer;
        }

        .timeline-item-date {
            white-space: wrap
        }
    </style>
@endsection
