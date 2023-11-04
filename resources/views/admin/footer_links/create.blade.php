@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300 p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Footer Bağlantısı Oluştur</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if ($errors->any())
                        <div class="alert alert-danger text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="p-4 code-to-copy">
                        <form action="{{ route('admin.footer_links.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="title">Başlık</label>
                                <textarea class="form-control" id="title" name="title" type="text" placeholder="Başlık"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="url">Bağlantı URL</label>
                                <input class="form-control" id="url" name="url" type="text" placeholder="Bağlantı Url">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="widget">Grup Adı</label>
                                <input class="form-control" id="widget" name="widget" type="text"
                                    placeholder="Grup Adı">
                            </div>
                            <button type="submit" class="btn btn-primary"> Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
