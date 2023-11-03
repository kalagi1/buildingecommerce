@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <div class="row gy-3 mb-6 justify-content-between">
            <div class="col-md-12 col-auto">
                <h2 class="mb-2 text-1100">{{ $user->name }} Hoş Geldiniz.</h2>
                @if (isset($user->parent))
                    <span class="badge bg-info "> Kurumsal Hesap:
                        {{ $user->parent->name }}</span>
                @endif
            </div>
        </div>
        <div class="row align-items-center mb-4">
            <div class="col-md-3 col-12 mb-3">
                <div class="d-flex align-items-center bg-white border rounded-sm p-2">
                    <svg viewBox="0 0 24 24" width="30" height="30" stroke="red" stroke-width="2" fill="red"
                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                        </polygon>
                    </svg>
                    <div class="ms-2">
                        <div class="d-flex align-items-end">
                            @if ($user->plan)
                                <span class="fs-1 fw-semi-bold text-900" style="font-size: 16px !important;">
                                    {{ $user->plan->subscriptionPlan->name }} Paketi
                                </span>
                            @else
                                <span class="fs-1 fw-semi-bold text-900" style="font-size: 16px !important;">
                                    Henüz paket almadınız
                                </span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            @if ($user->plan)
                <div class="col-md-3 col-12 mb-3">
                    <div class="d-flex align-items-center bg-white border rounded-sm p-2">
                        <svg viewBox="0 0 24 24" width="30" height="30" stroke="blue" stroke-width="2"
                            fill="blue" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $user->plan->project_limit }}</h2>
                                <span class="fs-1 fw-semi-bold text-900" style="font-size: 16px !important;">Proje
                                    Limiti</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 mb-3">
                    <div class="d-flex align-items-center bg-white border rounded-sm p-2">
                        <svg viewBox="0 0 24 24" width="30" height="30" stroke="green" stroke-width="2"
                            fill="green" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $user->plan->user_limit }}</h2>
                                <span class="fs-1 fw-semi-bold text-900" style="font-size: 16px !important;">Alt Kullanıcı
                                    Limiti</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 mb-3">
                    <div class="d-flex align-items-center bg-white border rounded-sm p-2">
                        <svg viewBox="0 0 24 24" width="30" height="30" stroke="currentColor" stroke-width="2"
                            fill="orange" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <div class="ms-2">
                            <div class="d-flex align-items-end">
                                <h2 class="mb-0 me-2">{{ $user->plan->housing_limit }}</h2>
                                <span class="fs-1 fw-semi-bold text-900" style="font-size: 16px !important;">Konut
                                    Limiti</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
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
