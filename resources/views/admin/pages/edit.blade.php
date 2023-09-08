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
                                <label class="form-label" for="title">Page Title</label>
                                <input class="form-control" id="title" name="title" type="text"
                                    placeholder="Page Title" value="{{ $page->title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="content">Page Content</label>
                                <textarea id="editor" name="content">{{ $page->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_title">Meta Title</label>
                                <input class="form-control" id="meta_title" name="meta_title" type="text"
                                    placeholder="Meta Title" value="{{ $page->meta_title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_description">Meta Description</label>
                                <textarea class="form-control" id="meta_description" name="meta_description"
                                    rows="3" placeholder="Meta Description">{{ $page->meta_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_keywords">Meta Keywords</label>
                                <input class="form-control" id="meta_keywords" name="meta_keywords" type="text"
                                    placeholder="Meta Keywords" value="{{ $page->meta_keywords }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_author">Meta Author</label>
                                <input class="form-control" id="meta_author" name="meta_author" type="text"
                                    placeholder="Meta Author" value="{{ $page->meta_author }}">
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
