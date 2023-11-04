@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300  p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Yeni Ekle</h4>
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
                        <form action="{{ route('admin.social_media_icons.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Simge Adı</label>
                                <input class="form-control" id="name" name="name" type="text"
                                    placeholder="Simge Adı">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="url">URL</label>
                                <input class="form-control" id="url" name="url" type="text" placeholder="URL">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="icon_class">Simge</label>
                                <input class="form-control" id="icon_class" name="icon_class" type="text"
                                    placeholder="Simge">
                                <span>Bu <a href="https://fontawesome.com/search?f=brands&o=r">linkten</a> simge seçimi yapabilirsiniz.</span>
                            </div>
                            <button type="submit" class="btn btn-primary">Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor');
    </script>
    @stack('scripts')
@endsection
