@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Reklam Bannerı Oluştur</h2>
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

                                    <form class="row g-3 needs-validation" id="adBannerForm" novalidate="" method="POST"
                                        action="{{ route('admin.adBanners.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <label class="form-label" for="image">Görseli</label>
                                            <input name="image" class="form-control" id="image" type="file"
                                                accept="image/*" required />
                                        </div>

                                        <div class="col-md-12">
                                            <div class="d-flex align-items-center">
                                                <label class="form-label" for="background_color" style="margin-right: 10px">Arkaplan Rengi</label>
                                                <input name="background_color" class="form-control" id="background_color"
                                                    type="color" value="" required="">
                                            </div>
                                            <div class="valid-feedback">İyi Görünüyor!</div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label" for="link">Link</label>
                                            <input name="link" class="form-control" id="link" type="url"
                                                value="" required="">
                                            <div class="valid-feedback">İyi Görünüyor!</div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Oluştur</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
