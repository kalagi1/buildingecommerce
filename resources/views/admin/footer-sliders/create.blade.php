@extends('admin.layouts.master')

@section('content')
<div class="content">
    <h2 class="mb-2 lh-sm">Footer Slider Oluştur</h2>
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

                                <form class="row g-3 needs-validation" id="sliderForm" novalidate="" method="POST"
                                    action="{{ route('admin.footer-sliders.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">Slider Başlığı</label>
                                        <input name="title" class="form-control" id="title"
                                            type="text" value="" required="">
                                        <div class="valid-feedback">İyi Görünüyor!</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="image">Slider Görseli</label>
                                        <input name="image" class="form-control" id="image" type="file"
                                            accept="image/*" required />
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
