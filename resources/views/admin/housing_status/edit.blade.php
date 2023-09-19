@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Konut Tipleri</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
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
                                        action="{{ route('admin.housing_status.update', $housingStatus->id) }}">
                                        @csrf
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Başlık</label>
                                            <input name="name" class="form-control" id="validationCustom01"
                                                type="text" value="{{ $housingStatus->name }}" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom04">Durum</label>
                                            <select name="active" class="form-select" id="validationCustom04"
                                                required="">
                                                <option selected disabled value="0">Seç...</option>
                                                <option {{ $housingStatus->status == '1' ? 'selected' : '' }} value="1">
                                                    Aktif
                                                </option>
                                                <option {{ $housingStatus->acstatustive == '0' ? 'selected' : '' }} value="0">
                                                    Pasif
                                                </option>
                                            </select>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input @if($housingStatus->in_dashboard) checked @endif name="in_dashboard" class="form-check-input" id="in_dashboard" type="checkbox" />
                                                <label class="form-check-label" for="in_dashboard">Anasayfa'da Gözüksün</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="dashboard_order">Anasayfa'da Gözükme Sırası</label>
                                            <input name="dashboard_order" class="form-control" name="dashboard_order" id="dashboard_order"
                                                type="text" @if(!$housingStatus->in_dashboard) disabled @endif value="{{ $housingStatus->dashboard_order }}" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>

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
        $('#in_dashboard').change(function(){
            if(this.checked) {
                $('#dashboard_order').removeAttr('disabled')
            } else {
                $('#dashboard_order').attr('disabled','disabled')
            }
        })
    </script>
@endsection