@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-12 col-xl-12 order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 p-0" data-component-card="data-component-card">
                        <div class="card-header border-bottom border-300 bg-soft">
                            <div class="row g-3 justify-content-between align-items-center">
                                <div class="col-12 col-md">
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Belge Doğrulama -
                                        Kullanıcı : {{ $user_e->name . ' - ' . $user_e->id }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="p-4">
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
                                <form action="{{ route('admin.update-corporate-status', ['user' => $user_e->id]) }}"
                                    method="POST" class="row">
                                    <div class="col-12">
                                        @if ($user_e->type == 2)
                                            <div class="form-group">
                                                <a target="_blank"
                                                    href="{{ route('admin.get.tax-document', ['user' => $user_e->id]) }}"
                                                    class="btn btn-blue mb-2">İmza Sirküsünü Gör</a>
                                                <select name="tax_document_approve" class="form-control">
                                                    <option
                                                        value="0"{{ $user_e->tax_document_approve == 0 ? ' selected' : null }}>
                                                        İmza Sirküsünü Onaylamıyorum</option>
                                                    <option
                                                        value="1"{{ $user_e->tax_document_approve == 1 ? ' selected' : null }}>
                                                        İmza Sirküsünü Onaylıyorum</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <a target="_blank"
                                                    href="{{ route('admin.get.record-document', ['user' => $user_e->id]) }}"
                                                    class="btn btn-blue mb-2">Vergi Levhasını Gör</a>
                                                <select name="record_document_approve" class="form-control">
                                                    <option
                                                        value="0"{{ $user_e->record_document_approve == 0 ? ' selected' : null }}>
                                                        Vergi Levhasını Onaylamıyorum</option>
                                                    <option
                                                        value="1"{{ $user_e->record_document_approve == 1 ? ' selected' : null }}>
                                                        Vergi Levhasını Onaylıyorum</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <a target="_blank"
                                                href="{{ route('admin.get.identity-document', ['user' => $user_e->id]) }}"
                                                class="btn btn-blue mb-2">Yetkilinin Kimlik Belgesini Gör</a>
                                            @csrf
                                            <select name="identity_document_approve" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->identity_document_approve == 0 ? ' selected' : null }}>
                                                    Yetkilinin Kimlik Belgesini Onaylamıyorum</option>
                                                <option
                                                    value="1"{{ $user_e->identity_document_approve == 1 ? ' selected' : null }}>
                                                    Yetkilinin Kimlik Belgesini Onaylıyorum</option>
                                            </select>
                                        </div>
                                        @if ($user_e->type == 2)
                                            <div class="form-group">
                                                <a target="_blank"
                                                    href="{{ route('admin.get.company-document', ['user' => $user_e->id]) }}"
                                                    class="btn btn-blue mb-2">Müteahhitlik Belgesini Gör</a>
                                                <select name="company_document_approve" class="form-control">
                                                    <option
                                                        value="0"{{ $user_e->company_document_approve == 0 ? ' selected' : null }}>
                                                        Müteahhitlik Belgesini Onaylamıyorum</option>
                                                    <option
                                                        value="1"{{ $user_e->company_document_approve == 1 ? ' selected' : null }}>
                                                        Müteahhitlik Belgesini Onaylıyorum</option>
                                                </select>
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <label for="note">Not:</label>
                                            <textarea name="note" id="note" rows="5" class="form-control">{{ $user_e->corporate_account_note }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Durum:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->corporate_account_status == 0 ? ' selected' : null }}>
                                                    Onaylanmadı</option>
                                                <option
                                                    value="1"{{ $user_e->corporate_account_status == 1 ? ' selected' : null }}>
                                                    Onaylandı</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg">Firma Onayını
                                                Güncelle</button>
                                        </div>
                                    </div>
                                </form>
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

@section('css')
    <style>
        .btn-blue {
            background-color: #0080c7 !important;
            color: white
        }En geç 12 saat içerisinde
    </style>
@endsection
