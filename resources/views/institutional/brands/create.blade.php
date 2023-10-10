@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Marka Oluştur</h2>
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
                                        action="{{ route('institutional.brands.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <label class="form-label" for="title">Başlık</label>
                                            <input name="title" class="form-control" id="title"
                                                type="text" value="{{ old('title') }}" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="logo">Logo</label>
                                            <input name="logo" class="form-control" id="logo"
                                                type="file" accept="image/*" required="">
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label" for="cover_photo">Kapak Fotoğrafı</label>
                                            <input name="cover_photo" class="form-control" id="cover_photo"
                                                type="file" accept="image/*" required="">
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" value="1" name="status" id="flexSwitchCheckCheckedDisabled" type="checkbox" checked="" />
                                                <label class="form-check-label"  for="flexSwitchCheckCheckedDisabled">Aktif</label>
                                            </div>
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

    </div>
@endsection
