@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300 p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Sayfayı Düzenle</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 code-to-copy">
                        <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="title">Sayfa Başlığı</label>
                                <input class="form-control" id="title" name="title" type="text"
                                    placeholder="Sayfa Başlığı" value="{{ $page->title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="content">Sayfa İçeriği</label>
                                <textarea id="editor" name="content">{{ $page->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_title">Meta Başlık</label>
                                <input class="form-control" id="meta_title" name="meta_title" type="text"
                                    placeholder="Meta Başlık" value="{{ $page->meta_title }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_description">Meta Açıklama</label>
                                <textarea class="form-control" id="meta_description" name="meta_description"
                                    rows="3" placeholder="Meta Açıklama">{{ $page->meta_description }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_keywords">Meta Anahtar Kelimeler</label>
                                <input class="form-control" id="meta_keywords" name="meta_keywords" type="text"
                                    placeholder="Meta Anahtar Kelimeler" value="{{ $page->meta_keywords }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="meta_author">Meta Yazarı</label>
                                <input class="form-control" id="meta_author" name="meta_author" type="text"
                                    placeholder="Meta Yazarı" value="{{ $page->meta_author }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="loc">Konum</label>
                                <select name="location" id="loc" class="form-control">
                                    <option value="header"{{$page->location == 'header' ? ' selected' : null}}>Header</option>
                                    <option value="footer"{{$page->location == 'footer' ? ' selected' : null}}>Footer</option>
                                </select>
                            </div>
                            <div class="mb-3 footer-link-area" style="display: none;">
                                <label for="link" class="form-label">Footer Widget:</label>
                                <select name="widget" id="link" class="form-control">
                                    @foreach ($footerLinks as $link)
                                    <option value="{{$link->widget}}"{{$page->widget == $link->widget ? ' selected' : null}}>{{$link->widget}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Sayfayı Güncelle</button>
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
    <script>
        $('#loc').on('change', function()
        {
            if ($(this).val() == 'footer')
                $('.footer-link-area').slideDown();
            else
                $('.footer-link-area').slideUp();
        });

        $('#loc').trigger('change');
    </script>
    @stack('scripts')
@endsection
