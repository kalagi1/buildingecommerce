@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konut Tipleri</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-10 order-1 order-xl-0">
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
                                        action="{{ route('admin.housing_types.store') }}">
                                        @csrf
                                        <div class="col-md-4">
                                            <label class="form-label" for="validationCustom01">Başlık</label>
                                            <input name="title" class="form-control" id="validationCustom01"
                                                type="text" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label" for="validationCustom02">Slug</label>
                                            <input name="slug" class="form-control" id="validationCustom02"
                                                type="text" value="" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label" for="validationCustom04">Durum</label>
                                            <select name="active" class="form-select" id="validationCustom04"
                                                required="">
                                                <option selected disabled value="0">Seç...</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Pasif</option>
                                            </select>

                                        </div>
                                        <!--input for FormBuilder JSON-->
                                        <input type="hidden" name="form_json" id="form_json">
                                        
                                        <div id="fb-editor"></div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Kaydet</button>
                                        </div>
                                        
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-xl-2">
                    <div class="position-sticky mt-xl-4" style="top: 80px;">
                        <h5 class="lh-1">On this page </h5>
                        <hr class="text-300" />
                        <ul class="nav nav-vertical flex-column doc-nav" data-doc-nav="data-doc-nav">
                            <li class="nav-item"> <a class="nav-link" href="#docs">Docs</a></li>
                            <li class="nav-item"> <a class="nav-link" href="#example">Example</a></li>
                        </ul>
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
        jQuery(function($) {
            var options = {
                onSave: function(evt, formData) {
                    document.getElementById("form_json").value = (formData);
                    console.log(JSON.stringify(formData))
                },
            };

            $(document.getElementById('fb-editor')).formBuilder(options);

        });
    </script>
@endsection
