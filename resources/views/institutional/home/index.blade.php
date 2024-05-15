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
                        {{ $userLog->corporate_type ?? 'Bireysel Hesap' }}</span>

                </div>

            </div>
        @endif

        <div class="row g-4">
            <div class="col-12 col-xxl-6">
                <div class="mb-8">
                    <h2 class="mb-2"> Sayın {{ $userLog->name }}
                    </h2>
                    <h5 class="text-body-tertiary fw-semibold"> Emlak Sepette'ye Hoş Geldiniz.</h5>
                </div>
                <div class="row align-items-center g-4">
                    @if (!empty($userLog->corporate_type))
                        <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                            <div class="d-flex align-items-center">
                                <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="35px" height="35px"
                                    viewBox="0 0 56.486 56.486" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path
                                                d="M51.734,16.604c-0.256-1.472-1.485-3.322-2.743-4.131L30.518,0.603c-1.259-0.808-3.296-0.803-4.55,0.014L7.604,12.572
                                                                                   c-1.254,0.815-2.48,2.672-2.739,4.145L2.319,31.218c-0.085,0.493,0.024,1.143,0.244,1.454c0.22,0.312,0.761,0.387,1.208,0.166
                                                                                   l22.035-10.823c1.342-0.658,3.52-0.663,4.864-0.003l22.158,10.829c0.447,0.219,0.948,0.015,1.116-0.453l0.061-0.164
                                                                                   c0.171-0.47,0.239-1.248,0.153-1.739L51.734,16.604z" />
                                            <path
                                                d="M25.8,24.485L5.943,34.108l1.051,19.674c0.08,1.494,1.357,2.704,2.853,2.704h9.788c1.497,0,2.758-0.076,2.819-0.17
                                                                                   c0.061-0.092,0.108-1.382,0.108-2.877V43.108c0.389-0.006,0.756-0.1,1.082-0.27c0.688,0.36,1.603,0.351,2.283-0.023
                                                                                   c0.696,0.383,1.633,0.383,2.328,0c0.694,0.382,1.628,0.384,2.32,0.005c0.702,0.383,1.646,0.377,2.342-0.016
                                                                                   c0.335,0.188,0.716,0.288,1.118,0.3v10.335c0,1.495,0.034,2.785,0.078,2.877c0.044,0.094,1.291,0.17,2.788,0.17h9.852
                                                                                   c1.496,0,2.737-1.211,2.773-2.707l0.498-20.543l-19.325-8.81C29.342,23.809,27.146,23.833,25.8,24.485z M14.531,48.471h-2.708
                                                                                   v-2.369h2.708V48.471z M14.531,45.201h-2.708v-3.048h2.708V45.201z M18.143,48.471h-2.709v-2.369h2.709V48.471z M18.143,45.201
                                                                                   h-2.709v-3.048h2.709V45.201z M42.014,42.153h2.426v2.764h-2.426V42.153z M42.014,45.822h2.426v2.65h-2.426V45.822z
                                                                                    M38.121,42.153h2.991v2.764h-2.991V42.153z M38.121,45.822h2.991v2.65h-2.991V45.822z M34.973,40.639
                                                                                   c0.004,0.004,0.007,0.012,0.011,0.016l0.244,0.324h-0.023c0.057,0.135,0.092,0.28,0.092,0.435c0,0.604-0.492,1.091-1.094,1.091
                                                                                   c-0.494,0-0.896-0.338-1.029-0.791h-0.309c-0.133,0.453-0.536,0.791-1.031,0.791c-0.496,0-0.896-0.338-1.03-0.791H30.55
                                                                                   c-0.132,0.453-0.534,0.791-1.029,0.791c-0.497,0-0.897-0.338-1.032-0.791h-0.265c-0.134,0.453-0.537,0.791-1.032,0.791
                                                                                   c-0.496,0-0.897-0.338-1.03-0.791h-0.267c-0.133,0.453-0.537,0.791-1.031,0.791c-0.495,0-0.896-0.338-1.03-0.791h-0.178
                                                                                   c-0.134,0.453-0.536,0.791-1.032,0.791c-0.602,0-1.09-0.487-1.09-1.091c0-0.243,0.096-0.457,0.23-0.639l1.05-1.601h11.061
                                                                                   L34.973,40.639z M32.984,33.97h-9.141v-6.603h9.141V33.97z" />
                                        </g>
                                    </g>
                                </svg>
                                <div class="ms-3">
                                    <h4 class="mb-0">{{ $housingCounts }}</h4>
                                    <p class="text-body-secondary fs-9 mb-0">İlan</p>
                                </div>
                                <p class="text-body-secondary fs-9 mb-0">Yayındaki emlak ilanı sayısı</p>


                            </div>

                        </div>
                        @if (Auth::user()->corporate_type != 'Emlak Ofisi')
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                                <div class="d-flex align-items-center">
                                    <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="50px" height="50px"
                                        viewBox="0 0 209.19 209.19" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path
                                                    d="M62.615,77.431l41.196-20.237l42.828,20.273c0.719,0.339,1.465,0.498,2.211,0.498c1.94,0,3.799-1.094,4.688-2.962
                                                                                    c1.222-2.592,0.116-5.685-2.471-6.906l-12.717-6.021v-4.437c0-3.304-2.317-5.985-5.181-5.985c-2.725,0-4.942,2.443-5.141,5.537
                                                                                    l-22.053-10.439c-1.427-0.672-3.083-0.666-4.503,0.033L58.035,68.128c-2.565,1.261-3.623,4.366-2.365,6.935
                                                                                    C56.941,77.642,60.05,78.698,62.615,77.431z" />
                                                <path
                                                    d="M197.595,100.406c-1.529-0.683-3.381,0.134-4.271,1.815l-9.739-11.365c-0.63-0.736-1.558-1.141-2.526-1.11l-29.673,1.083
                                                                                    c-1.752,0.063-3.125,1.542-3.06,3.293c0.059,1.759,1.536,3.126,3.289,3.06l28.144-1.023l18.911,22.073
                                                                                    c0.318,0.369,0.697,0.646,1.115,0.832c1.085,0.489,2.402,0.342,3.367-0.482c1.335-1.146,1.485-3.152,0.346-4.483l-5.615-6.557
                                                                                    l1.111-2.485C199.82,103.206,199.197,101.121,197.595,100.406z" />
                                                <path
                                                    d="M8.145,119.06c0.417-0.188,0.799-0.462,1.114-0.832l18.909-22.072l28.144,1.023c1.752,0.067,3.23-1.3,3.291-3.059
                                                                                    c0.063-1.752-1.304-3.23-3.06-3.294l-29.675-1.083c-0.967-0.031-1.899,0.375-2.525,1.11l-9.74,11.365
                                                                                    c-0.89-1.679-2.739-2.499-4.267-1.816c-1.605,0.715-2.233,2.799-1.405,4.647l1.11,2.485l-5.611,6.56
                                                                                    c-1.146,1.331-0.989,3.337,0.348,4.483C5.741,119.402,7.058,119.549,8.145,119.06z" />
                                                <path
                                                    d="M182.316,140.859c0.653-0.52,1.204-1.177,1.563-1.988l10.062-22.514l-15.526-17.804l-23.911,0.76l-9.846,22.027
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
                                                                                    L164.856,130.671z M172.641,134.152l5.284-11.813l5.317,2.375l-5.28,11.82L172.641,134.152z" />
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
                    @endif

                    <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="d-flex align-items-center">
                            <svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" width="35px" height="35px"
                                viewBox="0 0 58.341 58.342" xml:space="preserve">
                                <g>
                                    <g>
                                        <path
                                            d="M11.073,14.385h27.256l7.069,7.86l2.933-2.639c1.157-1.041,1.253-2.823,0.212-3.979l-7.201-8.005h-4.935V2.361h-6.059
                                                                                                                v5.261H8.106l-7.361,7.999c-1.054,1.145-0.98,2.928,0.164,3.983l2.904,2.67L11.073,14.385z" />
                                        <path
                                            d="M36.76,26.767c2.312,0,4.541,0.763,6.362,2.14c0.122-0.092,0.25-0.176,0.375-0.261v-5.784l-5.54-6.2H11.821l-6.084,6.952
                                                                                                                v23.67c0,1.557,1.262,2.817,2.818,2.817h23.692c-5.362-5.629-5.882-10.521-5.928-11.21c-0.083-0.547-0.124-1.06-0.124-1.56
                                                                                                                C26.195,31.508,30.935,26.767,36.76,26.767z" />
                                        <path
                                            d="M49.861,29.198c-2.537,0-4.808,1.119-6.363,2.885c-1.553-1.764-3.824-2.885-6.36-2.885c-4.685,0-8.483,3.798-8.483,8.482
                                                                                                                c0,0.479,0.049,0.945,0.125,1.403h-0.007c0,0,0.374,9.058,14.726,16.896c14.126-7.157,14.728-16.896,14.728-16.896h-0.008
                                                                                                                c0.075-0.458,0.124-0.925,0.124-1.403C58.341,32.996,54.545,29.198,49.861,29.198z M36.873,33.05
                                                                                                                c-2.759,0-5.001,2.244-5.001,5.001c0,0.145-0.117,0.26-0.261,0.26s-0.26-0.115-0.26-0.26c0-3.044,2.477-5.521,5.521-5.521
                                                                                                                c0.144,0,0.261,0.116,0.261,0.26C37.133,32.934,37.016,33.05,36.873,33.05z" />
                                    </g>
                                </g>
                            </svg>
                            <div class="ms-2">
                                <div class="d-flex align-items-end">
                                    <h2 class="mb-0 me-2">{{ $projectFavorites + $housingFavorites }}</h2><span
                                        class="fs-7 fw-semibold text-body">İlan</span>
                                </div>
                                <p class="text-body-secondary fs-9 mb-0">Favorilerinizdeki İlan Sayısı</p>
                            </div>
                        </div>

                    </div>

                </div>
                <hr class="bg-body-secondary mb-6 mt-4">

            </div>
            <div class="col-12 col-xxl-6">
                @if (Auth::check() && Auth::user()->has_club == 1)
                    <div class="row g-3">
                        <h5 class="text-body-tertiary fw-semibold">Emlak Kulüp İstatistiği</h5>
                        <div class="col-md-6 col-12">
                            <div class="card h-100">
                                <div class="card-body">
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

                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center ">
                                        <div class="d-flex bg-success-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-dollar-sign text-success-dark"
                                                style="width:24px; height:24px">
                                                <line x1="12" y1="1" x2="12" y2="23">
                                                </line>
                                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6">
                                                </path>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color:orange">Onaydaki Komisyon
                                                Tutarı</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus0, 2, ',', '.') }} ₺

                                            </h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center ">
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
                                            <p class="fw-bold mb-1" style="color: red">Reddedilen Komisyon
                                                Tutarı</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ number_format($balanceStatus2, 2, ',', '.') }} ₺

                                            </h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div
                                        class="d-sm-block d-inline-flex d-md-flex flex-xl-column flex-xxl-row align-items-center align-items-xl-start align-items-xxl-center ">
                                        <div class="d-flex bg-primary-subtle rounded flex-center me-3 mb-sm-3 mb-md-0 mb-xl-3 mb-xxl-0"
                                            style="width:32px; height:32px"><svg xmlns="http://www.w3.org/2000/svg"
                                                width="16px" height="16px" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-bar-chart-2 text-success-dark"
                                                style="width:16px; height:16px">
                                                <line x1="18" y1="20" x2="18" y2="10">
                                                </line>
                                                <line x1="12" y1="20" x2="12" y2="4">
                                                </line>
                                                <line x1="6" y1="20" x2="6" y2="14">
                                                </line>
                                            </svg></div>
                                        <div>
                                            <p class="fw-bold mb-1" style="color: red">Başarı Yüzdesi</p>
                                            <h4 class="fw-bolder text-nowrap">
                                                {{ $successPercentage }} %

                                            </h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        @if (count($collections) > 0)
                            <div class="col-md-12 col-12">
                                <h5 class="text-body-tertiary fw-semibold">Son Eklenen Koleksiyonlar</h5>
                                <ul class="list-group" style="margin-top: 1rem;">
                                    @foreach ($collections as $item)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a
                                                href="{{ route('institutional.sharer.links.index', ['id' => $item->id]) }}">

                                                {{ $item->name }}
                                            </a><span class="badge badge-phoenix badge-phoenix-primary rounded-pill">
                                                {{ count($item->clicks) }} Görüntülenme</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </div>
                @else
                    <a href="{{ route('institutional.sharer.index') }}">
                        <div class="card border h-100 w-100 overflow-hidden">

                            <div class="card-body position-relative">
                                <img src="{{ asset('popup2.jpeg') }}" alt=""
                                    style="width:100%;height:100%;object-fit:cover">
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>


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
