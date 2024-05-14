@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        @if (isset($userLog->parent))
            <div class="row gy-3 mb-5 justify-content-between">
                <div class="col-md-12 col-auto">
                    <span class="badge bg-info "> Kurumsal Hesap:
                        {{ $userLog->parent->name }}</span>
                    <span class="badge bg-info "> Referans Kodu:
                        {{ $userLog->code }}</span>

                </div>

            </div>
        @else
            <div class="row gy-3 mb-5 justify-content-between">
                <div class="col-md-12 col-auto">
                    <span class="badge bg-info ">
                        {{ $userLog->corporate_type }}</span>

                </div>

            </div>
        @endif

        @if (Auth::check() && Auth::user()->type != '1' && Auth::user()->type != '3' && Auth::user()->parent != '4')
            <div class="row g-4">
                <div class="col-12 col-xxl-6">
                    <div class="mb-8">
                        <h2 class="mb-2"> Sayın {{ $userLog->name }}
                        </h2>
                        <h5 class="text-body-tertiary fw-semibold"> Emlak Sepette'ye Hoş Geldiniz.</h5>
                    </div>
                    <div class="row align-items-center g-4">

                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="d-flex align-items-center">
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 width="50px" height="50px" viewBox="0 0 58.341 58.342"
	 xml:space="preserve">
<g>
	<g>
		<path d="M11.073,14.385h27.256l7.069,7.86l2.933-2.639c1.157-1.041,1.253-2.823,0.212-3.979l-7.201-8.005h-4.935V2.361h-6.059
			v5.261H8.106l-7.361,7.999c-1.054,1.145-0.98,2.928,0.164,3.983l2.904,2.67L11.073,14.385z"/>
		<path d="M36.76,26.767c2.312,0,4.541,0.763,6.362,2.14c0.122-0.092,0.25-0.176,0.375-0.261v-5.784l-5.54-6.2H11.821l-6.084,6.952
			v23.67c0,1.557,1.262,2.817,2.818,2.817h23.692c-5.362-5.629-5.882-10.521-5.928-11.21c-0.083-0.547-0.124-1.06-0.124-1.56
			C26.195,31.508,30.935,26.767,36.76,26.767z"/>
		<path d="M49.861,29.198c-2.537,0-4.808,1.119-6.363,2.885c-1.553-1.764-3.824-2.885-6.36-2.885c-4.685,0-8.483,3.798-8.483,8.482
			c0,0.479,0.049,0.945,0.125,1.403h-0.007c0,0,0.374,9.058,14.726,16.896c14.126-7.157,14.728-16.896,14.728-16.896h-0.008
			c0.075-0.458,0.124-0.925,0.124-1.403C58.341,32.996,54.545,29.198,49.861,29.198z M36.873,33.05
			c-2.759,0-5.001,2.244-5.001,5.001c0,0.145-0.117,0.26-0.261,0.26s-0.26-0.115-0.26-0.26c0-3.044,2.477-5.521,5.521-5.521
			c0.144,0,0.261,0.116,0.261,0.26C37.133,32.934,37.016,33.05,36.873,33.05z"/>
	</g>
</g>
</svg>
                                <div class="ms-2">
                                    <div class="d-flex align-items-end">
                                        <h2 class="mb-0 me-2">{{ $housingCounts }}</h2><span
                                            class="fs-7 fw-semibold text-body">İlan</span>
                                    </div>
                                    <p class="text-body-secondary fs-9 mb-0">Yayındaki emlak ilanı sayısı</p>
                                </div>
                            </div>

                        </div>
                        @if (Auth::user()->corporate_type != 'Emlak Ofisi')
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                <div class="d-flex align-items-center">
                                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 width="50px" height="50px" viewBox="0 0 209.19 209.19"
	 xml:space="preserve">
<g>
	<g>
		<path d="M62.615,77.431l41.196-20.237l42.828,20.273c0.719,0.339,1.465,0.498,2.211,0.498c1.94,0,3.799-1.094,4.688-2.962
			c1.222-2.592,0.116-5.685-2.471-6.906l-12.717-6.021v-4.437c0-3.304-2.317-5.985-5.181-5.985c-2.725,0-4.942,2.443-5.141,5.537
			l-22.053-10.439c-1.427-0.672-3.083-0.666-4.503,0.033L58.035,68.128c-2.565,1.261-3.623,4.366-2.365,6.935
			C56.941,77.642,60.05,78.698,62.615,77.431z"/>
		<path d="M197.595,100.406c-1.529-0.683-3.381,0.134-4.271,1.815l-9.739-11.365c-0.63-0.736-1.558-1.141-2.526-1.11l-29.673,1.083
			c-1.752,0.063-3.125,1.542-3.06,3.293c0.059,1.759,1.536,3.126,3.289,3.06l28.144-1.023l18.911,22.073
			c0.318,0.369,0.697,0.646,1.115,0.832c1.085,0.489,2.402,0.342,3.367-0.482c1.335-1.146,1.485-3.152,0.346-4.483l-5.615-6.557
			l1.111-2.485C199.82,103.206,199.197,101.121,197.595,100.406z"/>
		<path d="M8.145,119.06c0.417-0.188,0.799-0.462,1.114-0.832l18.909-22.072l28.144,1.023c1.752,0.067,3.23-1.3,3.291-3.059
			c0.063-1.752-1.304-3.23-3.06-3.294l-29.675-1.083c-0.967-0.031-1.899,0.375-2.525,1.11l-9.74,11.365
			c-0.89-1.679-2.739-2.499-4.267-1.816c-1.605,0.715-2.233,2.799-1.405,4.647l1.11,2.485l-5.611,6.56
			c-1.146,1.331-0.989,3.337,0.348,4.483C5.741,119.402,7.058,119.549,8.145,119.06z"/>
		<path d="M182.316,140.859c0.653-0.52,1.204-1.177,1.563-1.988l10.062-22.514l-15.526-17.804l-23.911,0.76l-9.846,22.027
			c-0.619,1.39-0.876,2.762-0.797,3.863c-2.57-0.615-5.106-1.153-7.57-1.608c1.273-1.522,2.067-3.449,2.067-5.588V77.814
			l-34.949-16.163L68.33,78.687v39.319c0,2.539,0.558,4.798,1.434,6.393c-1.896,0.387-3.845,0.835-5.814,1.311
			c0.228-1.167,0.046-2.737-0.683-4.374l-9.844-22.026l-23.913-0.76l-15.528,17.804l10.064,22.515
			c0.392,0.88,1.004,1.581,1.73,2.111C16.464,146.591,7.59,153.75,0,162.932h112.114c-2.313-5.373-7.791-13.213-20.809-18.442
			c-13.211-5.308-14.101-21.401-14.104-21.439v-22.973c0-0.958,0.77-1.729,1.726-1.729h15.332c0.955,0,1.728,0.773,1.728,1.729
			v20.991c-0.01,0.041-1.696,5.705,17.951,15.396c11.311,5.574,8.966,18.743,6.372,26.471h88.881
			C200.668,153.707,191.555,146.5,182.316,140.859z M29.966,136.531l-5.282-11.82l5.32-2.375l5.282,11.812L29.966,136.531z
			 M37.755,133.05l-5.284-11.82l5.323-2.379l5.28,11.817L37.755,133.05z M48.668,130.248l-5.376-12.029
			c-0.238-0.537,0-1.163,0.534-1.403l8.584-3.839c0.534-0.236,1.16,0.003,1.398,0.54l5.934,13.274
			C56.122,127.769,52.414,128.916,48.668,130.248z M114.094,118.468h-9.501V97.367h9.501V118.468z M127.996,118.468h-9.5V97.367h9.5
			V118.468z M164.64,118.218l-5.209,11.652c-3.736-1.369-7.429-2.529-11.046-3.515l5.735-12.84c0.239-0.537,0.869-0.78,1.403-0.54
			l8.582,3.839C164.64,117.055,164.879,117.681,164.64,118.218z M164.856,130.671l5.28-11.816l5.325,2.378l-5.284,11.82
			L164.856,130.671z M172.641,134.152l5.284-11.813l5.317,2.375l-5.28,11.82L172.641,134.152z"/>
	</g>
</g>
</svg>
                                    <div class="ms-2">
                                        <div class="d-flex align-items-end">
                                            <h2 class="mb-0 me-2">{{ $projectCounts }}</h2><span
                                                class="fs-7 fw-semibold text-body">İlan</span>
                                        </div>
                                        <p class="text-body-secondary fs-9 mb-0">Yayındaki proje ilanı sayısı</p>
                                    </div>
                                </div>

                            </div>
                        @endif
                        {{-- <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="d-flex align-items-center"><span
                                    class="fs-4 lh-1 uil uil-invoice text-warning-dark"></span>
                                <div class="ms-2">
                                    <div class="d-flex align-items-end">
                                        <h2 class="mb-0 me-2">23</h2><span
                                            class="fs-7 fw-semibold text-body">Invoices</span>
                                    </div>
                                    <p class="text-body-secondary fs-9 mb-0">Soon to be cleared</p>
                                </div>
                            </div>

                        </div> --}}

                    </div>
                    <hr class="bg-body-secondary mb-6 mt-4">
                    <div class="row flex-between-center mb-4 g-3">
                        <div class="col-auto">
                            <h3>Total sells</h3>
                            <p class="text-body-tertiary lh-sm mb-0">Payment received across all channels</p>
                        </div>
                        <div class="col-8 col-sm-4"><select class="form-select form-select-sm"
                                id="select-gross-revenue-month">
                                <option>Mar 1 - 31, 2022</option>
                                <option>April 1 - 30, 2022</option>
                                <option>May 1 - 31, 2022</option>
                            </select></div>
                    </div>
                    <div class="echart-total-sales-chart"
                        style="min-height: 320px; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;"
                        _echarts_instance_="ec_1715613235385">
                        <div
                            style="position: relative; width: 878px; height: 320px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                            <canvas data-zr-dom-id="zr_0" width="878" height="320"
                                style="position: absolute; left: 0px; top: 0px; width: 878px; height: 320px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                        </div>
                        <div class=""
                            style="position: absolute; display: block; border-style: solid; white-space: nowrap; z-index: 9999999; box-shadow: rgba(0, 0, 0, 0.2) 1px 2px 10px; background-color: rgb(239, 242, 246); border-width: 1px; border-radius: 4px; color: rgb(20, 24, 36); font: 14px / 21px &quot;Microsoft YaHei&quot;; padding: 10px; top: 0px; left: 0px; transform: translate3d(356px, 58px, 0px); border-color: rgb(203, 208, 221); pointer-events: none; visibility: hidden; opacity: 0;">
                            <div class="ms-1">
                                <h6 class="fs-9 text-body-tertiary false"><svg class="svg-inline--fa fa-circle me-2"
                                        style="color: #3874ff;" aria-hidden="true" focusable="false" data-prefix="fas"
                                        data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z">
                                        </path>
                                    </svg><!-- <span class="fas fa-circle me-2" style="color:#3874ff"></span> Font Awesome fontawesome.com -->
                                    May 12 : 500
                                </h6>
                                <h6 class="fs-9 text-body-tertiary mb-0"><svg class="svg-inline--fa fa-circle me-2"
                                        style="color: #0097eb;" aria-hidden="true" focusable="false" data-prefix="fas"
                                        data-icon="circle" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z">
                                        </path>
                                    </svg><!-- <span class="fas fa-circle me-2" style="color:#0097eb"></span> Font Awesome fontawesome.com -->
                                    Apr 12 : 50
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xxl-6">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Total orders<span
                                                    class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2"><span
                                                        class="badge-label">-6.8%</span></span></h5>
                                            <h6 class="text-body-tertiary">Last 7 days</h6>
                                        </div>
                                        <h4>16,247</h4>
                                    </div>
                                    <div class="d-flex justify-content-center px-4 py-6">
                                        <div class="echart-total-orders"
                                            style="height: 85px; width: 115px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;"
                                            _echarts_instance_="ec_1715613235391">
                                            <div
                                                style="position: relative; width: 115px; height: 85px; padding: 0px; margin: 0px; border-width: 0px;">
                                                <canvas data-zr-dom-id="zr_0" width="115" height="85"
                                                    style="position: absolute; left: 0px; top: 0px; width: 115px; height: 85px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                            </div>
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Completed</h6>
                                            <h6 class="text-body fw-semibold mb-0">52%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-primary-subtle me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Pending payment</h6>
                                            <h6 class="text-body fw-semibold mb-0">48%</h6>
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
                                                    class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2">
                                                    <span class="badge-label">+26.5%</span></span></h5>
                                            <h6 class="text-body-tertiary">Last 7 days</h6>
                                        </div>
                                        <h4>356</h4>
                                    </div>
                                    <div class="pb-0 pt-4">
                                        <div class="echarts-new-customers"
                                            style="height: 180px; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;"
                                            _echarts_instance_="ec_1715613235386">
                                            <div
                                                style="position: relative; width: 381px; height: 180px; padding: 0px; margin: 0px; border-width: 0px;">
                                                <canvas data-zr-dom-id="zr_0" width="381" height="180"
                                                    style="position: absolute; left: 0px; top: 0px; width: 381px; height: 180px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                            </div>
                                            <div class=""></div>
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
                                            <h5 class="mb-2">Top coupons</h5>
                                            <h6 class="text-body-tertiary">Last 7 days</h6>
                                        </div>
                                    </div>
                                    <div class="pb-4 pt-3">
                                        <div class="echart-top-coupons"
                                            style="height: 115px; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;"
                                            _echarts_instance_="ec_1715613235387">
                                            <div
                                                style="position: relative; width: 381px; height: 115px; padding: 0px; margin: 0px; border-width: 0px; cursor: default;">
                                                <canvas data-zr-dom-id="zr_0" width="381" height="115"
                                                    style="position: absolute; left: 0px; top: 0px; width: 381px; height: 115px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                            </div>
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Percentage discount</h6>
                                            <h6 class="text-body fw-semibold mb-0">72%</h6>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary-lighter me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Fixed card discount</h6>
                                            <h6 class="text-body fw-semibold mb-0">18%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-info-dark me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Fixed product discount</h6>
                                            <h6 class="text-body fw-semibold mb-0">10%</h6>
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
                                            <h6 class="text-body-tertiary">Last 7 days</h6>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center pt-3 flex-1">
                                        <div class="echarts-paying-customer-chart"
                                            style="height: 100%; width: 100%; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative;"
                                            _echarts_instance_="ec_1715613235390">
                                            <div
                                                style="position: relative; width: 381px; height: 144px; padding: 0px; margin: 0px; border-width: 0px;">
                                                <canvas data-zr-dom-id="zr_0" width="381" height="144"
                                                    style="position: absolute; left: 0px; top: 0px; width: 381px; height: 144px; user-select: none; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); padding: 0px; margin: 0px; border-width: 0px;"></canvas>
                                            </div>
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="bullet-item bg-primary me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Paying customer</h6>
                                            <h6 class="text-body fw-semibold mb-0">30%</h6>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="bullet-item bg-primary-subtle me-2"></div>
                                            <h6 class="text-body fw-semibold flex-1 mb-0">Non-paying customer</h6>
                                            <h6 class="text-body fw-semibold mb-0">70%</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-black position-relative fw-bold" style="margin-bottom: 10px !important">
                        <span class="bg-soft pe-2">
                            Sayın {{ $userLog->name }}, Emlak Sepette'ye Hoş Geldiniz.
                        </span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    {{-- <span class="mt-5">Emlak Sepette, ücretsiz, sınırsız ve süresiz ilan paylaşımı
                        imkanı sunarak ilanlarınızın satışına aracılık eder. Değerli kurumsal üyelerimizden aylık sabit
                        ücret talep
                        etmeyiz. İlanlarınızın daha hızlı satılmasına ve kiralanmasına aracılık ederiz.

                        Emlak ilanlarınızın, emlak sepette ile satılması durumunda %0.5 hizmet bedeli alınır.
                        .</span> --}}


                </div>
            </div>
        @else
            <div class="d-flex mb-5 " id="scrollspyStats">
                <div class="col">
                    <h3 class="mb-0 text-black position-relative fw-bold" style="margin-bottom: 10px !important">
                        <span class="bg-soft pe-2">
                            Sayın {{ $userLog->name }}, Emlak Sepette'ye Hoş Geldiniz.
                        </span><span
                            class="border border-primary-200 position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
                    </h3>
                    <span class="mt-5">Emlak Sepette'ye üye olduğunuz için teşekkür ederiz. Sitemizde keyifli
                        alışverişler
                        dileriz.</span>


                </div>
            </div>
        @endif


        {{-- @if (Auth::check() && Auth::user()->type != '3')
            <!-- HTML -->
            <button class="chatbox-open">
                <i class="fa fa-comment" aria-hidden="true"></i>
            </button>
            <button class="chatbox-close">
                <i class="fa fa-close" aria-hidden="true"></i>
            </button>
            <div class="chatbox-popup">
                <header class="chatbox-popup__header">
                    <aside style="flex:8">
                        <h4 style="color: white">Emlak Sepette Canlı Destek</h4>
                    </aside>
                </header>
                <main class="chatbox-popup__main">
                    <div class="chatbox-messages">
                        <div class="msg left-msg">

                            <div class="msg-bubble">

                                <div class="msg-text">
                                    Merhaba size nasıl yardımcı olabiliriz ?
                                </div>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="chatbox-popup__footer">
                    <aside style="flex:10">
                        <textarea id="userMessage" type="text" placeholder="Mesajınızı Yazınız..." autofocus
                            onkeydown="handleKeyPress(event)"></textarea>
                    </aside>
                    <aside style="flex:1;color:#888;text-align:center;">
                        <button onclick="sendMessage()" class="btn btn-primary"><i class="fa fa-paper-plane"
                                aria-hidden="true"></i></button>
                    </aside>
                </footer>
            </div>
        @endif --}}

        @if (Auth::check() && Auth::user()->has_club == 1)
            <div class="row">
                <div class="col-xl-5 col-xxl-4">
                    <div class="sticky-leads-sidebar">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12 col-sm-auto flex-1">

                                        <div class="d-md-flex d-xl-block align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-xl me-3"><img class="rounded-circle"
                                                        src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}"
                                                        alt=""></div>
                                                <div>
                                                    <h5>{{ Auth::user()->name }}</h5>
                                                    <span style="display: flex"> <img style="height: 21px;"
                                                            class="lazy entered loading"
                                                            src="https://emlaksepette.com/yeniler_2.svg" alt="Yeniler"
                                                            data-ll-status="loading">Emlak Kulüp Üyesi</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="border-top border-bottom border-translucent" id="leadDetailsTable">
                                        <div class="table-responsive scrollbar mx-n1 px-1">
                                            <table class="table fs-9 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="sort white-space-nowrap align-middle pe-3 ps-0 "
                                                            scope="col" data-sort="dealName"
                                                            style="width:15%; min-width:200px">
                                                            @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                                Portföy Adı:
                                                            @else
                                                                Koleksiyon Adı:
                                                            @endif
                                                        </th>
                                                        <th class="sort align-middle pe-6  text-end" scope="col"
                                                            data-sort="amount" style="width:15%; min-width:100px">İlan
                                                            Sayısı</th>

                                                    </tr>
                                                </thead>
                                                <tbody class="list" id="lead-details-table-body">
                                                    @foreach ($collections as $item)
                                                        <tr
                                                            class="hover-actions-trigger btn-reveal-trigger position-static">

                                                            <td class="dealName align-middle white-space-nowrap py-2 ps-0">
                                                                <a class="fw-semibold text-primary"
                                                                    href="#!">{{ $item->name }}</a>
                                                            </td>
                                                            <td
                                                                class="amount align-middle white-space-nowrap text-start fw-bold text-body-tertiary py-2 text-end pe-6">
                                                                {{ count($item->links) }}</td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-xxl-8">
                    <div class="card mb-5">
                        <div class="card-body">
                            <div class="row g-4 g-xl-1 g-xxl-3 justify-content-between">
                                <div class="col-sm-auto">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center ">
                                        <div class="d-flex bg-info-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-code text-info-dark"
                                                style="width:24px; height:24px">
                                                <polyline points="16 18 22 12 16 6"></polyline>
                                                <polyline points="8 6 2 12 8 18"></polyline>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color:green">Toplam Kazanç</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus1, 2, ',', '.') }} ₺
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-auto">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5 border-translucent">
                                        <div class="d-flex bg-success-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-dollar-sign text-success-dark"
                                                style="width:24px; height:24px">
                                                <line x1="12" y1="1" x2="12" y2="23">
                                                </line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color:orange">Onaydaki Komisyon Tutarı</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus0, 2, ',', '.') }} ₺

                                            </h4>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-auto">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center border-start-sm ps-sm-5 border-translucent">
                                        <div class="d-flex bg-primary-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" class="feather feather-layout text-primary-dark"
                                                style="width:24px; height:24px">
                                                <rect x="3" y="3" width="18" height="18" rx="2"
                                                    ry="2"></rect>
                                                <line x1="3" y1="9" x2="21" y2="9">
                                                </line>
                                                <line x1="9" y1="21" x2="9" y2="9">
                                                </line>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color: red">Reddedilen Komisyon Tutarı</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus2, 2, ',', '.') }} ₺

                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-xl-4 mb-7">
                        <div class="row mx-0 mx-sm-3 mx-lg-0 px-lg-0">
                            <div class="col-sm-12 col-xxl-6 border-bottom border-end-xxl border-translucent py-3">
                                <table class="w-100 table-stats table-stats">
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-success-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-bar-chart-2 text-success-dark"
                                                            style="width:16px; height:16px">
                                                            <line x1="18" y1="20" x2="18"
                                                                y2="10"></line>
                                                            <line x1="12" y1="20" x2="12"
                                                                y2="4"></line>
                                                            <line x1="6" y1="20" x2="6"
                                                                y2="14"></line>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Başarı Yüzdesi (%)</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2">
                                                <p class="ps-6 ps-sm-0 fw-semibold mb-0 mb-0 pb-3 pb-sm-0">
                                                    {{ $successPercentage }} %</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex bg-info-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-trending-up text-info-dark"
                                                            style="width:16px; height:16px">
                                                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                                            <polyline points="17 6 23 6 23 12"></polyline>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Toplam Kazanç</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2">
                                                <p class="ps-6 ps-sm-0 fw-semibold mb-0">
                                                    {{ number_format($balanceStatus1, 0, ',', '.') }} ₺</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 col-xxl-6 border-bottom border-translucent py-3">
                                <table class="w-100 table-stats">
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-inline-flex align-items-center">
                                                    <div class="d-flex bg-primary-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-phone text-primary-dark"
                                                            style="width:16px; height:16px">
                                                            <path
                                                                d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                            </path>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Telefon</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2"><a
                                                    class="ps-6 ps-sm-0 fw-semibold mb-0 pb-3 pb-sm-0 text-body"
                                                    href="tel:{{ Auth::user()->phone }}">{{ Auth::user()->phone }}</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex bg-warning-subtle rounded-circle flex-center me-3"
                                                        style="width:24px; height:24px"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16px"
                                                            height="16px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-mail text-warning-dark"
                                                            style="width:16px; height:16px">
                                                            <path
                                                                d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                            </path>
                                                            <polyline points="22,6 12,13 2,6"></polyline>
                                                        </svg></div>
                                                    <p class="fw-bold mb-0">Email</p>
                                                </div>
                                            </td>
                                            <td class="py-2 d-none d-sm-block pe-sm-2">:</td>
                                            <td class="py-2"><a class="ps-6 ps-sm-0 fw-semibold mb-0 text-body"
                                                    href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 col-xl-6 col-xxl-5">
                    <a href="{{ route('institutional.sharer.index') }}">
                        <div class="card border h-100 w-100 overflow-hidden">

                            <div class="card-body position-relative">
                                <img src="{{ asset('popup2.jpeg') }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover">
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        @endif



    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Sayfa yüklendiğinde mevcut sohbet geçmişini çekmek için bir AJAX çağrısı yapabilirsiniz
            fetchChatHistory();
        });

        function fetchChatHistory() {
            $.ajax({
                url: 'chat/history',
                method: 'GET',
                success: function(response) {

                    renderChatHistory(response);
                },
                error: function(error) {
                    console.error('Sohbet geçmişi alınamadı:', error);
                }
            });

        }

        function renderChatHistory(chatHistory) {
            const chatboxMessages = document.querySelector('.chatbox-messages');

            chatHistory.forEach(entry => {
                const messageElement = document.createElement('div');
                const messageType = entry.receiver_id == 4 ? 'user' : 'admin';

                messageElement.className = messageType == 'admin' ? 'msg left-msg' : 'msg right-msg';
                messageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${entry.content}
                </div>
            </div>
        `;
                chatboxMessages.appendChild(messageElement);
            });
        }


        var isFirstMessage = true;

        function sendMessage() {
            var userMessage = document.getElementById('userMessage').value;
            var chatboxMessages = document.querySelector('.chatbox-messages');

            // Kullanıcının mesajını ekle
            var userMessageElement = document.createElement('div');
            userMessageElement.className = 'msg right-msg';
            userMessageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${userMessage}
                </div>
            </div>
        `;
            chatboxMessages.appendChild(userMessageElement);

            $.ajax({
                type: 'POST',
                url: "{{ route('messages.store') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'content': userMessage,
                },
                success: function(response) {
                    // Başarıyla mesaj gönderildiğinde yapılacak işlemler
                    console.log(response.message);
                    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
                },
                error: function(error) {
                    toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');

                }
            });


            // Kullanıcının girdiği mesaj alanını temizle
            document.getElementById('userMessage').value = '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        $(".chatbox-open").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeIn();
        });

        $(".chatbox-close").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeOut();
        });

        $(".chatbox-maximize").click(() => {
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeOut();
            $(".chatbox-panel").fadeIn();
            $(".chatbox-panel").css({
                display: "flex"
            });
        });

        $(".chatbox-minimize").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeIn();
        });

        $(".chatbox-panel-close").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-open").fadeIn();
        });

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
