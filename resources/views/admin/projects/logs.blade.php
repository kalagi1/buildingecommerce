@extends('admin.layouts.master')

@section('content')

    @php
        $turkishMonths = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
    @endphp

    <div class="content">
        <nav class="mb-2 breadcrumb-sticky-top" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}">Admin Panel</a></li>
                <li class="breadcrumb-item active">Admin Proje Kayıtları</li>
            </ol>
        </nav>
        <h2 class="text-bold mb-5 page-title-sticky-top">Admin Proje Kayıtları</h2>
        <div class="row gx-xl-8 gx-xxl-11">
            <div class="col-xl-5 p-xxl-7">
                <div class="ms-xxl-3 d-none d-xl-block position-sticky" style="top: 30%"><img class="d-dark-none img-fluid"
                        src="https://prium.github.io/phoenix/v1.13.0/assets/img/spot-illustrations/timeline.png"
                        alt=""><img class="d-light-none img-fluid"
                        src="../assets/img/spot-illustrations/timeline-dark.png" alt=""></div>
            </div>
            <div class="col-xl-7 scrollbar">
                <div>
                    @if (count($logs))
                        @foreach ($logs as $log)
                            <h4 class="py-3 border-y border-300 mb-5 ms-8">
                                {{ $turkishMonths[date('n', strtotime($log->created_at)) - 1] . ', ' . date('d Y', strtotime($log->created_at)) }}
                            </h4>
                            <div class="timeline-basic mb-2">
                                <div class="timeline-item">
                                    <div class="row g-3">
                                        <div class="col-auto">
                                            <div class="timeline-item-bar position-relative">
                                                <div class="icon-item icon-item-md rounded-7 border"><span
                                                        class="fa-solid fa-clipboard text-success fs--1"></span></div><span
                                                    class="timeline-bar border-end border-dashed border-300"></span>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="d-flex justify-content-between">
                                                <div class="d-flex mb-2">
                                                    <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">
                                                        @if ($log->is_rejected)
                                                            Proje Reddedildi
                                                        @else
                                                            Yeni Bir Kayıt
                                                        @endif
                                                    </h6>
                                                </div>
                                                <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span
                                                        class="fa-regular fa-clock me-1"></span>{{ date('H:i', strtotime($log->created_at)) }}
                                                </p>
                                            </div>
                                            <h6 class="fs--2 fw-normal mb-3"><a class="fw-semi-bold"
                                                    href="javascript:void()">{{ $log->user->name }}</a> tarafından</h6>
                                            <p class="fs--1 text-800 w-sm-60 mb-5">{{ $log->reason }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-danger text-white">Bu projeye ait kayıt bulunamadı</div>
                    @endif
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
