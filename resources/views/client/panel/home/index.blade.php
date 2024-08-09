@extends('client.layouts.masterPanel')
@section('content')
    <section>
        <div class="">
            <div class="container">

                <div class=" alert alert-white card  alert-dismissible fade show mb-5" role="alert"
                    style="box-shadow: none; background-color: #dbedff; ">
                    <div class="card-body d-flex justify-content-start align-items-center flex-wrap">
                        <div class="flex-grow-1 ">
                            <h4 style="font-size:large">Hoşgeldin <strong>{{ Auth::user()->name }},</strong></h4>
                            <div class="welcomeText" style="font-weight: 400; font-size: 15px;">
                                "Ziyaretçi veya müşterilerinizden sipariş, talep, yorum veya diğer bekleyen işleri
                                incelemeyi unutmayın."
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4">
                        <div class="single homes-content details mb-30 h-320">
                            <div class="" style="font-size:large">
                                Ziyaretci Sayısı
                                {{-- <span>(Son 24 Saat)</span> --}}
                            </div>
                            {{-- <div>
                                <span>Son Güncelleme: 20 haziran 13:30</span>
                            </div> --}}

                            <div class="mt-5">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6>İlan</h6>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <h6 style="float: right;">Ziyaret Sayısı</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table">
                                       
                                            <tbody>
                                                @foreach ($housingViews as $housingView)
                                                    <tr>
                                                        <td>
                                                            <div class="text-truncate  justify-content-between"
                                                                style="max-width: 200px;">
                                                                <a href=""><span
                                                                        class="text-truncate">{{ $housingView->title }}</span></a>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <span>{{ $housingView->views_count }}</span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                <!-- Diğer satırlar burada -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card single homes-content details mb-30">
                            <div class="card-body text-left ">
                                <center>
                                    <h4 class="">BEKLEYEN İŞLER</h4>
                                    <h7 style="color: #999;">Aşağıdan bekleyen işlerinizi kontrol edebilirsiniz</h7>
                                </center>
                                <br><br>
                                <div id="bekleyen-isler">
                                    <a href="">
                                        <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                            style="border: 1px solid #fff;">
                                            <div class="rounded bg-primary text-white p-2 d-flex justify-content-center align-items-center"
                                                style="font-size: 18px ; width: 40px">
                                                <i class="fa fa-shopping-basket"></i>
                                            </div>
                                            <div class="p-2"
                                                style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                Toplam İlan Sayısı </div>
                                            <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                {{ $pendingJobs['totalListingCount'] }}
                                            </div>
                                        </div>
                                    </a>

                                    <a href="">
                                        <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                            style="border: 1px solid #fff;">
                                            <div class="rounded bg-success text-white p-2 d-flex justify-content-center align-items-center"
                                                style="font-size: 18px ; width: 40px; ">
                                                <i class="fa fa-ticket-alt"></i>
                                            </div>
                                            <div class="p-2"
                                                style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                Onay Bekleyen İlanlar </div>
                                            <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                {{ $pendingJobs['listingsPendingApprovalCount'] }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="">
                                        <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                            style="border: 1px solid #fff;">
                                            <div class="rounded bg-success text-white p-2 d-flex justify-content-center align-items-center"
                                                style="font-size: 18px ; width: 40px; ">
                                                <i class="fa fa-ticket-alt"></i>
                                            </div>
                                            <div class="p-2"
                                                style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                Aktif İlanlar </div>
                                            <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                {{ $pendingJobs['activeListingsCount'] }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="">
                                        <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                            style="border: 1px solid #fff;">
                                            <div class="rounded bg-warning text-dark p-2 d-flex justify-content-center align-items-center"
                                                style="font-size: 18px ; width: 40px; ">
                                                <i class="fa fa-comment"></i>
                                            </div>
                                            <div class="p-2"
                                                style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                Askıya Alınan İlanlar </div>
                                            <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                {{ $pendingJobs['listingsSuspended'] }}
                                            </div>
                                        </div>
                                    </a>
                                    <a href="">
                                        <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                            style="border: 1px solid #fff;">
                                            <div class="rounded bg-warning text-dark p-2 d-flex justify-content-center align-items-center"
                                                style="font-size: 18px ; width: 40px; ">
                                                <i class="fa fa-comment"></i>
                                            </div>
                                            <div class="p-2"
                                                style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                Koleksiyon Sayısı </div>
                                            <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                {{ $pendingJobs['CollectionCount'] }}
                                            </div>
                                        </div>
                                    </a>
                                   @if ($pendingJobs['user']->type == 2)
                                        <a href="">
                                            <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                                style="border: 1px solid #fff;">
                                                <div class="rounded bg-white text-dark p-2 d-flex justify-content-center align-items-center"
                                                    style="font-size: 18px ; width: 40px; ">
                                                    <i class="fa fa-money-bill-alt"></i>
                                                </div>
                                                <div class="p-2"
                                                    style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                    Alt Çalışan Sayısı</div>
                                                <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                    style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                    {{ $pendingJobs['SubordinateCount'] }}
                                                </div>
                                            </div>
                                        </a>

                                    @endif 
                                    {{-- <div class="col-md-12 p-2 d-flex justify-content-between mb-3 bg-light"
                                        style="border: 1px solid #fff;">
                                        <div class="rounded bg-info text-white p-2 d-flex justify-content-center align-items-center"
                                            style="font-size: 18px ; width: 40px; ">
                                            <i class="fas fa-gift"></i>
                                        </div>
                                        <div class="p-2"
                                            style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                            Tek Ürün Siparişleri </div>
                                        <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                            style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                            0
                                        </div>
                                    </div> --}}
                                    <a href="">
                                        <div class="col-md-12 p-2 d-flex justify-content-between mb-1 bg-light"
                                            style="border: 1px solid #fff;">
                                            <div class="rounded bg-secondary text-white p-2 d-flex justify-content-center align-items-center"
                                                style="font-size: 18px ; width: 40px; ">
                                                <i class="fas fa-handshake"></i>
                                            </div>
                                            <div class="p-2"
                                                style="font-size: 15px ; font-weight: 500; flex:1; margin-left: 15px;">
                                                Pazar Teklifileri </div>
                                            <div class="rounded bg-white text-dark p-2 d-flex align-items-center justify-content-center "
                                                style="font-size: 18px ; font-weight: 600; border: 1px solid #f3f3f3; width: 50px">
                                                {{ $pendingJobs['marketOffers'] }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-8">
                        {{-- <div class="single homes-content details mb-30">
                            <h3>Performans Verileri</h3>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div id="chart"></div>
                                    <div id="chart2"></div>

                                </div>

                                <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
                                    <div class="col-12 mb-4">
                                        <button type="button" class="btn btn-outline-primary active w-100">Yayındaki İlanlar ({{$monthlyListingCounts['totalCount']}})</button>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <button type="button" class="btn btn-outline-primary w-100" >Görüntülenme (24)</button>
                                           
                                    </div>

                                    <div class="col-12 mb-4">
                                        <button type="button" class="btn btn-outline-primary w-100">Favoriye Alınma (24)</button>
                                            
                                    </div>

                                    <div class="col-12">
                                        <button type="button" class="btn btn-outline-primary w-100">Koleksiyona Alınma (14)</button>
                                      
                                    </div>
                                </div>
                            </div>

                        </div> --}}


                        <div class="single homes-content details mb-30">
                            <h3>Performans Verileri</h3>
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="chart1" role="tabpanel"
                                            aria-labelledby="chart1-tab">
                                            <!-- İlk grafik içeriği buraya gelecek -->
                                            <div id="chart1Content"></div>
                                        </div>
                                        <div class="tab-pane fade" id="chart2" role="tabpanel"
                                            aria-labelledby="chart2-tab">
                                            <!-- İkinci grafik içeriği buraya gelecek -->
                                            <div id="chart2Content"></div>
                                        </div>
                                        <!-- Diğer grafikler buraya eklenebilir -->
                                    </div>
                                </div>

                                <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
                                    <div class="col-12 mb-4">
                                        <button type="button" class="btn btn-outline-primary active w-100"
                                            onclick="openChart('chart1')" id="button1">Yayındaki İlanlar
                                        </button>
                                    </div>

                                    <div class="col-12 mb-4">
                                        <button type="button" class="btn btn-outline-primary w-100" id="button2"
                                            onclick="openChart('chart2')">Koleksiyona Alınma</button>
                                    </div>

                                    <!-- Diğer butonlar buraya eklenebilir -->
                                </div>
                            </div>
                        </div>


                        <div class="single homes-content details mb-30">
                            <div class="align-items-center">
                                <div class="">
                                    <h3>Satış İstatistikleri</h3>


                                    <div class="row justify-content-between mb-4">
                                        <div class="col-sm-4 mb-3 mb-sm-0">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Toplam Satış</h5>
                                                    <p class="card-text display-4 border-bottom border-danger mb-4 ">
                                                        {{ $housingSalesStatistics['totalSales'] }}</p>
                                                    <p class="fw-bold" style="font-size: 14px; ">
                                                        {{ $housingSalesStatistics['totalRevenue'] }} ₺</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Bugünki Satış</h5>
                                                    <p class="card-text display-4 border-bottom border-danger mb-4 ">
                                                        {{ $housingSalesStatistics['todaySales'] }}</p>
                                                    <p class="fw-bold" style="font-size: 14px; ">
                                                        {{ $housingSalesStatistics['dailyRevenue'] }} ₺</p>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="card">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Son 1 Ayki Satış</h5>
                                                    <p class="card-text display-4 border-bottom border-danger mb-4 ">
                                                        {{ $housingSalesStatistics['lastMonthSales'] }}</p>
                                                    <p class="fw-bold" style="font-size: 14px; ">
                                                        {{ $housingSalesStatistics['monthlyRevenue'] }} ₺</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="single homes-content details mb-30 ">
                            <div class="">

                                <h3>Son 3 Emlak İlanı</h3>
                                <div class="mt-4 text-center">
                                    <table class="table-custom">
                                        <thead class="border-bottom border-danger">
                                            <tr>
                                                <th class="col-md-2">İlan Numarası</th>
                                                <th class="col-md-2">İlan İsmi</th>
                                                <th class="col-md-2">İlan Fiyatı</th>
                                                <th class="col-md-2">İlan Düzenle</th>
                                            </tr>
                                        </thead>
                                        <tbody class="mb-4">
                                            @foreach ($housings as $housing)
                                                <tr class="border-bottom border-danger">
                                                    <td>{{ $housing->id + 2000000 }}</td>
                                                    <td>
                                                        {{ $housing->title }}
                                                    </td>

                                                    <td>
                                                        @php
                                                            $housingData = json_decode(
                                                                $housing->housing_type_data,
                                                                true,
                                                            );
                                                            $price = isset($housingData['price'][0])
                                                                ? floatval($housingData['price'][0])
                                                                : 0;

                                                            // Fiyatı virgül ile binler basamağına ayırarak ve ₺ sembolü ile birlikte göster
                                                            $formattedPrice = number_format($price, 2, ',', '.') . ' ₺';

                                                            echo htmlspecialchars($formattedPrice);
                                                        @endphp
                                                    </td>
                                                    <td> <a class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                                            href="{{ route('institutional.housing.edit', ['id' => hash_id($housing->id)]) }}">Düzenle</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center align-items-center full-height mt-5">
                                        <a href="{{ route('institutional.housing.list') }}">Fazlasını Gör</a>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>



            </div>

        </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Buttonları seç
            const button1 = document.getElementById('button1');
            const button2 = document.getElementById('button2');


            // Buttonlara tıklama olaylarını ekle
            button1.addEventListener('click', function() {
                toggleActive(button1);
            });

            button2.addEventListener('click', function() {
                toggleActive(button2);
            });


            // Düğmeyi aktif veya pasif yapacak fonksiyon
            function toggleActive(button) {
                // Tüm düğmelerden 'active' sınıfını kaldır
                button1.classList.remove('active');
                button2.classList.remove('active');


                // Tıklanan düğmeye 'active' sınıfını ekle
                button.classList.add('active');

                console.log(button.id + " active");
            }
        });
    </script>

    <script>
        function openChart(chartId) {
            // Remove 'active' class from all chart buttons
            $('.chart-button').removeClass('active');

            // Add 'active' class to the clicked button
            $('#' + chartId + '-btn').addClass('active');

            // Hide all tab panes
            $('.tab-pane').removeClass('show active');

            // Show the corresponding tab pane
            $('#' + chartId).addClass('show active');

            // Optional: Render chart based on chartId
            renderChart(chartId);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options1 = {
                chart: {
                    type: 'line',
                    height: 350,
                    width: '100%',
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Emlaklar',
                    data: {!! $monthlyCounts['countsListings'] !!},
                    color: '#FF0000' // İlk veri seti için renk
                }, 
                @if ($monthlyCounts['user']->type == 2 && $monthlyCounts['user']->corporate_type = 'Banka' && $monthlyCounts['user']->corporate_type = 'İnşaat Ofisi' )
                {
                    name: 'Projeler',
                    data: {!! $monthlyCounts['countsProjects'] !!},
                    color: '#2f5f9e' // İkinci veri seti için renk
                }
                @endif
            ],
                xaxis: {
                    categories: {!! $monthlyCounts['monthsListings'] !!},


                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#chart1Content"), options1);
            chart1.render();
        });



        document.addEventListener('DOMContentLoaded', function() {
            var options2 = {
                chart: {
                    type: 'line',
                    height: 350,
                    width: '100%',
                    toolbar: {
                        show: true
                    }
                },
                series: [

                    {
                        name: 'Emlak Koleksiyonu',
                        data: {!! $monthlyCollectionCounts['countsListings'] !!}, // Emlak koleksiyon verileri
                        color: '#FF0000'
                    },
                    @if ($monthlyCollectionCounts['user']->type == 2 && $monthlyCounts['user']->corporate_type = 'Banka' && $monthlyCounts['user']->corporate_type = 'İnşaat Ofisi')
                        {
                            name: 'Proje Koleksiyonu',
                            data: {!! $monthlyCollectionCounts['countsProjects'] !!}, // Proje koleksiyon verileri  
                            color: '#2f5f9e'
                        }
                    @endif
                ],
                xaxis: {
                    categories: {!! $monthlyCollectionCounts['months'] !!} // Ayların listesi
                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        }
                    }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#chart2Content"), options2);
            chart2.render();
        });
    </script>
@endsection

@section('styles')
    <style>
        .table-custom {
            border-collapse: separate;
            border-spacing: 0 15px;
            /* Vertical spacing between rows */
        }
    </style>
@endsection
