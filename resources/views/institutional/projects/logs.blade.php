@extends('institutional.layouts.master')

@section('content')

@php 
  $turkishMonths = [
    "Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"
  ]
@endphp

<div class="content">
    
    <h2 class="text-bold mb-5 page-title-sticky-top">Admin Proje Kayıtları</h2>
    <div class="row gx-xl-8 gx-xxl-11">
      <div class="col-xl-12 scrollbar">
        <div>
          @if(count($logs))
            @foreach($logs as $log)
            <h4 class="py-3 border-y border-300 mb-5 ms-8">{{$turkishMonths[date('n',strtotime($log->created_at)) - 1].', '.date('d Y',strtotime($log->created_at))}}</h4>
            <div class="timeline-basic mb-2">
              <div class="timeline-item">
                <div class="row g-3">
                  <div class="col-auto">
                    <div class="timeline-item-bar position-relative">
                      <div class="icon-item icon-item-md rounded-7 border"><span class="fa-solid fa-clipboard text-success fs--1"></span></div><span class="timeline-bar border-end border-dashed border-300"></span>
                    </div>
                  </div>
                  <div class="col">
                    <div class="d-flex justify-content-between">
                      <div class="d-flex mb-2">
                        <h6 class="lh-sm mb-0 me-2 text-800 timeline-item-title">@if($log->is_rejected) Proje Reddedildi @else Yeni Bir Kayıt @endif</h6>
                      </div>
                      <p class="text-500 fs--1 mb-0 text-nowrap timeline-time"><span class="fa-regular fa-clock me-1"></span>{{date('H:i',strtotime($log->created_at))}}</p>
                    </div>
                    <h6 class="fs--2 fw-normal mb-3"><a class="fw-semi-bold" href="#!">Admin</a> tarafından</h6>
                    <p class="fs--1 text-800 w-sm-60 mb-5">{{$log->reason}}</p>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          @else 
            <div class="alert alert-danger">Bu projeye ait kayıt bulunamadı</div>
          @endif
        </div>
      </div>
    </div>
    <footer class="footer position-absolute">
      <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a></p>
        </div>
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600">v1.13.0</p>
        </div>
      </div>
    </footer>
  </div>
@endsection

@section('scripts')
    
@endsection
