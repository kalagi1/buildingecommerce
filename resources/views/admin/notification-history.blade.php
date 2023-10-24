@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-5">Bildirimler</h2>
        <h5 class="text-black mb-3">Bugün</h5>
        <div class="mx-n4 mx-lg-n6 mb-5 border-bottom border-300">
            @foreach (\App\Models\DocumentNotification::where('created_at', '>=', date('Y-m-d 00:00:00'))->where('created_at', '<=', date('Y-m-d 23:59:59'))->get() as $item)
            <div class="d-flex align-items-center justify-content-between py-3 border-300 px-lg-6 px-4 notification-card border-top read">
                <div class="d-flex">
                    <div class="me-3 flex-1 mt-2">
                        <p class="fs--1 text-1000"><span class="me-1">💬</span>{!! $item->text !!}</p>
                        <p class="text-800 fs--1 mb-0"><svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512zM232 256C232 264 236 271.5 242.7 275.1L338.7 339.1C349.7 347.3 364.6 344.3 371.1 333.3C379.3 322.3 376.3 307.4 365.3 300L280 243.2V120C280 106.7 269.3 96 255.1 96C242.7 96 231.1 106.7 231.1 120L232 256z"></path></svg><!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">{{ $item->created_at }}</span></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <h5 class="text-black mb-3">Daha Önce</h5>
        <div class="mx-n4 mx-lg-n6 mb-5 border-bottom border-300">
            @foreach (\App\Models\DocumentNotification::where('created_at', '<=', date('Y-m-d 23:59:59', strtotime('-1 Days')))->get() as $item)
                <div class="d-flex align-items-center justify-content-between py-3 border-300 px-lg-6 px-4 notification-card border-top read">
                    <div class="d-flex">
                        <div class="me-3 flex-1 mt-2">
                            <p class="fs--1 text-1000"><span class="me-1">💬</span>{!! $item->text !!}</p>
                            <p class="text-800 fs--1 mb-0"><svg class="svg-inline--fa fa-clock me-1" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512zM232 256C232 264 236 271.5 242.7 275.1L338.7 339.1C349.7 347.3 364.6 344.3 371.1 333.3C379.3 322.3 376.3 307.4 365.3 300L280 243.2V120C280 106.7 269.3 96 255.1 96C242.7 96 231.1 106.7 231.1 120L232 256z"></path></svg><!-- <span class="me-1 fas fa-clock"></span> Font Awesome fontawesome.com --><span class="fw-bold">{{ $item->created_at }}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection