@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <div class="row gy-3 mb-6 justify-content-between">
            <div class="col-md-12 col-auto">
                <h2 class="mb-2 text-1100">{{ $user->name }} Hoş Geldiniz.</h2>
                <h5 class="text-700 fw-semi-bold">Hesabınızı bu panelden yönetebilirsiniz.</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-12 mb-3">
                <div class="d-flex align-items-center">
                    <svg viewBox="0 0 24 24" width="30" height="30" stroke="red" stroke-width="2"
                        fill="red" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                        </polygon>
                    </svg>
                    <div class="ms-2">
                        <div class="d-flex align-items-end">
                            <span class="fs-1 fw-semi-bold text-900">{{ $user->plan->subscriptionPlan->name }} Paketi</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-3">
                <div class="d-flex align-items-center">
                    <svg viewBox="0 0 24 24" width="30" height="30" stroke="blue" stroke-width="2" fill="blue"
                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <div class="ms-2">
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 me-2">{{ $user->plan->project_limit }}</h2>
                            <span class="fs-1 fw-semi-bold text-900">Proje Limiti</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-3">
                <div class="d-flex align-items-center">
                    <svg viewBox="0 0 24 24" width="30" height="30" stroke="green" stroke-width="2" fill="green"
                        stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <div class="ms-2">
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 me-2">{{ $user->plan->user_limit }}</h2>
                            <span class="fs-1 fw-semi-bold text-900">Kullanıcı Limiti</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-12 mb-3">
                <div class="d-flex align-items-center">
                    <svg viewBox="0 0 24 24" width="30" height="30" stroke="currentColor" stroke-width="2"
                        fill="orange" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <div class="ms-2">
                        <div class="d-flex align-items-end">
                            <h2 class="mb-0 me-2">{{ $user->plan->housing_limit }}</h2>
                            <span class="fs-1 fw-semi-bold text-900">Konut Limiti</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
