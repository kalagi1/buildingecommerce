@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <div class="row gy-3 mb-6 justify-content-between">
            <div class="col-md-12 col-auto">
                <h2 class="mb-2 text-1100">{{ $userLog->name }} Hoş Geldiniz.</h2>
                @if (isset($userLog->parent))
                    <span class="badge bg-info "> Kurumsal Hesap:
                        {{ $userLog->parent->name }}</span>
                @endif
            </div>
        </div>
        <div class="d-flex mb-5 " id="scrollspyStats"><span class="fa-stack me-2 ms-n1"><svg
                    class="svg-inline--fa fa-circle fa-stack-2x text-primary" aria-hidden="true" focusable="false"
                    data-prefix="fas" data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512" data-fa-i2svg="">
                    <path fill="currentColor"
                        d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z">
                    </path>
                </svg><!-- <i class="fas fa-circle fa-stack-2x text-primary"></i> Font Awesome fontawesome.com --><svg
                    class="svg-inline--fa fa-percent fa-inverse fa-stack-1x text-primary-soft" aria-hidden="true"
                    focusable="false" data-prefix="fas" data-icon="percent" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                    <path fill="currentColor"
                        d="M374.6 73.39c-12.5-12.5-32.75-12.5-45.25 0l-320 320c-12.5 12.5-12.5 32.75 0 45.25C15.63 444.9 23.81 448 32 448s16.38-3.125 22.62-9.375l320-320C387.1 106.1 387.1 85.89 374.6 73.39zM64 192c35.3 0 64-28.72 64-64S99.3 64.01 64 64.01S0 92.73 0 128S28.7 192 64 192zM320 320c-35.3 0-64 28.72-64 64s28.7 64 64 64s64-28.72 64-64S355.3 320 320 320z">
                    </path>
                </svg><!-- <i class="fa-inverse fa-stack-1x text-primary-soft fas fa-percentage"></i> Font Awesome fontawesome.com --></span>
            <div class="col">
                <h3 class="mb-0 text-primary position-relative fw-bold">
                    <span class="bg-soft pe-2">
                        @if ($userLog->plan && $userLog->plan->status != 2 && $userLog->plan->subscription_plan_id != null)
                            @if ($userLog->plan->status == 0)
                                <span class="bg-soft pe-2 @if ($userLog->plan->status == 0) text-orange @endif">
                                    Ödeme site yöneticisi tarafından onaylandığında paketiniz aktif olacaktır.
                                </span>
                            @else
                                <span class="bg-soft pe-2">
                                    {{ $userLog->plan->subscriptionPlan->name }} Paketi
                                </span>
                            @endif
                        @else
                            <span class="bg-soft pe-2">
                                Henüz paket almadınız
                            </span>
                            <a href="{{ route('institutional.profile.upgrade') }}" class="btn btn-primary">Paket Satın Al</a>

                        @endif
                    </span><span
                        class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                </h3>
                <p class="mb-0">Bu alanda istatistik içeriklerinizi kolaylıkla görüntüleyebilirsiniz.</p>
            </div>
        </div>
        @if ($remainingPackage)
            <div class="card mb-5">
                <div class="card-body">
                    <div class="row g-4 g-xl-1 g-xxl-3 justify-content-between">
                        <div class="col-sm-auto">
                            <div
                                class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center">
                                <div class="d-flex bg-success-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                    style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg" width="16px"
                                        height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-home text-success-600 dark__text-success-300"
                                        style="width:24px; height:24px">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg></div>
                                <div>
                                    <p class="fw-bold mb-1">Proje Oluşturma Limiti</p>
                                    <h4 class="fw-bolder text-nowrap">{{ $remainingPackage->project_limit }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div
                                class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5">
                                <div class="d-flex bg-info-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                    style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg" width="16px"
                                        height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-code text-info-600 dark__text-info-300"
                                        style="width:24px; height:24px">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg></div>
                                <div>
                                    <p class="fw-bold mb-1">Alt Kullanıcı Oluşturma Limiti</p>
                                    <h4 class="fw-bolder text-nowrap">{{ $remainingPackage->user_limit }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div
                                class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5">
                                <div class="d-flex bg-primary-100 rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                    style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg" width="16px"
                                        height="16px" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-layout text-primary-600 dark__text-primary-300"
                                        style="width:24px; height:24px">
                                        <polyline points="9 11 12 14 22 4"></polyline>
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                    </svg></div>
                                <div>
                                    <p class="fw-bold mb-1">Konut Oluşturma Limiti</p>
                                    <h4 class="fw-bolder text-nowrap">{{ $remainingPackage->housing_limit }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        <div class="row">
            <div class="col-md-6">
                <div class="bg-white p-3 border rounded-md">
                    <strong>Firmanızın Konut İstatistiği</strong>
                    <div id="stat-1" style="height: 350px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="bg-white p-3 border rounded-md">
                    <strong>Firmanızın Proje İstatistiği</strong>
                    <div id="stat-2" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var dom = document.getElementById('stat-1');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            xAxis: {
                type: 'category',
                data: @json(
                    (function () {
                        $array = [];
                        for ($i = 1; $i <= date('m'); ++$i) {
                            $array[] = strftime('%B', strtotime(date("Y-{$i}-01 00:00:00")));
                        }
                
                        return $array;
                    })()),
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: @json($stats1_data),
                type: 'bar',
                showBackground: true,
                backgroundStyle: {
                    color: 'rgba(180, 180, 180, 0.2)'
                }
            }]
        };


        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    </script>
    <script>
        var dom = document.getElementById('stat-2');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};

        var option;

        option = {
            xAxis: {
                type: 'category',
                data: @json(
                    (function () {
                        $array = [];
                        for ($i = 1; $i <= date('m'); ++$i) {
                            $array[] = strftime('%B', strtotime(date("Y-{$i}-01 00:00:00")));
                        }
                
                        return $array;
                    })()),
            },
            yAxis: {
                type: 'value'
            },
            series: [{
                data: @json($stats2_data),
                type: 'bar',
                showBackground: true,
                backgroundStyle: {
                    color: 'rgba(180, 180, 180, 0.2)'
                }
            }]
        };


        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }

        window.addEventListener('resize', myChart.resize);
    </script>
@endsection

@section('css')
@endsection
