@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300  p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Edit Page</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 code-to-copy">
                        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name">Page Title</label>
                                <input class="form-control" id="name" name="title" type="text"
                                    placeholder="Page Title" value="{{ $page->title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Page Content</label>
                                <textarea id="editor" name="content">{{ $page->content }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Page</button>
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
