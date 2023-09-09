@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">İletişim Ayarları</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body p-0">
                                <div class="p-4">

                                    <form class="row g-3 needs-validation" novalidate="" method="POST"
                                        action="{{ route('admin.info.contact.set') }}" enctype="multipart/form-data">
                                        @csrf

                                       
                                        <div class="col-md-6">
                                            <label class="form-label" for="email">Email</label>
                                            <input name="email" class="form-control" id="email"
                                                type="text" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="phone">Telefon</label>
                                            <input name="phone" class="form-control" id="phone"
                                                type="text" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="working_time">Çalışma zamanı(09:00-17:00)</label>
                                            <input name="working_time" class="form-control" id="working_time"
                                                type="text" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                         <div class="col-md-6">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea class="form-control" id="address" name="address" rows="3"> </textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="location">Location:</label>
                                            <input name="location" class="form-control" id="location" readonly
                                                type="text" value="39.1667,35.6667" />
                                            <div id="mapContainer"></div>

                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Kaydet</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br
                            class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v1.13.0</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
@section('scripts')
    <script>
        jQuery($ => {
            $('#location').leafletLocationPicker({
                alwaysOpen: true,
                mapContainer: "#mapContainer",
                height: 300,
                map: {
                    zoom: 5
                }


            });
        })
    </script>
@endsection
