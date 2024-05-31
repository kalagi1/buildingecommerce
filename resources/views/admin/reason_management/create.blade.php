@extends('admin.layouts.master')

@section('content')
<div class="content">
    <h2 class="mb-2 lh-sm">Sebep Şablonları Oluştur</h2>
    <div class="mt-4">
        <div class="row g-4">
            <div class="col-12 col-xl-12 order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                        @if (session()->has('success'))
                            <div class="alert alert-success text-white">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger text-white">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body p-0">
                            <div class="p-4">
                                <form class="row g-3 needs-validation" id="emailTemplateForm" novalidate=""
                                    method="POST" action="{{ route('admin.reason.templates.store') }}">
                                    @csrf
                                    <input type="hidden" name="redirectUrl" id="redirectUrlInput" value="">
                                    <div class="col-md-12">
                                        <label class="form-label" for="title">Şablon Adı</label>
                                        <input name="title" class="form-control" id="title" type="text"  required>
                                        <div class="valid-feedback">İyi Görünüyor!</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="content">Konu</label>
                                        <textarea name="content" id="content" required></textarea>
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
<script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>

<script>
    CKEDITOR.replace('content', {
        allowedContent: true, // HTML etiketlerini temizlemek için
        enterMode: CKEDITOR.ENTER_BR // Satır değiştirme davranışını ayarlamak için
    });
</script>

<script>var currentUrl = window.location.href;

    // URL'deki parametreleri ayıklamak için bir fonksiyon
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }
    
    // redirectUrl parametresinin değerini al
    var redirectUrl = getParameterByName('redirectUrl', currentUrl);
    
    // Aldığınız değeri kullanarak, formun hidden input alanına ekleyebilirsiniz
    document.getElementById('redirectUrlInput').value = redirectUrl;</script>
@endsection
