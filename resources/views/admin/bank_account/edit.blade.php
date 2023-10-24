@extends('admin.layouts.master')

@section('content')
<div class="content">
    <h2 class="mb-2 lh-sm">Banka Hesabı Oluştur</h2>
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

                                <form class="row g-3 needs-validation" id="emailTemplateForm" novalidate=""
                                    method="POST" enctype="multipart/form-data" action="{{ route('admin.bank_account.update',$bankAccount->id) }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label class="form-label" for="name">Banka Resmi</label>
                                        <input name="image" class="form-control" type="file" value="">
                                        <div class="image-area mt-3">
                                            <img style="max-height: 50px" src="{{ URL::to('/').'/'.$bankAccount->image }}" alt="">
                                        </div>
                                        <div class="valid-feedback">İyi Görünüyor!</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Hesabın Alıcı Adı</label>
                                        <input value="{{$bankAccount->receipent_full_name}}" name="recipient_full_name" class="form-control" type="text" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label">Iban</label>
                                        <input value="{{$bankAccount->iban}}" name="iban" class="form-control" type="text" required>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Güncelle</button>
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
<script src="https://cdn.tiny.cloud/1/uzaxwtnfjkyj1l9egzl3mea3go0cq6xgmlkoanf5eb2jry8u/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
     tinymce.init({
        selector: 'textarea#body', // Hedef elementin id'si
        plugins: 'link code anchor autolink charmap codesample emoticons image lists media searchreplace table visualblocks wordcount', // İhtiyacınıza göre eklentileri ayarlayabilirsiniz
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        menubar: true,
        branding: true
    });
</script>
@endsection
