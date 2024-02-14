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
                                    @csrf
                                    @if ($user_e->type == 2)
                                        <div class="form-group">
                                            <label for="vergi_levhasi" class="mb-2 d-flex align-items-center">İmza Sirküsü:

                                                @if (!is_null($user_e->tax_document))
                                                    <div class="ml-2 mr-2">
                                                        <a target="_blank"
                                                            href="{{ url('storage/tax_document/'. $user_e->tax_document) }}"
                                                            download><i class="fa fa-download"></i></a>
                                                    </div>
                                                @endif

                                                @if ($user_e->tax_document_approve)
                                                    <span class="checkmark"></span> <span
                                                        style="color:green">Onaylandı</span>
                                                @endif
                                            </label>
                                            <select name="tax_document_approve" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->tax_document_approve == 0 ? ' selected' : null }}>
                                                    Onaylamıyorum</option>
                                                <option
                                                    value="1"{{ $user_e->tax_document_approve == 1 ? ' selected' : null }}>
                                                    Onaylıyorum</option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="sicil_belgesi" class="mb-2 d-flex align-items-center">Vergi Levhası:

                                                @if (!is_null($user_e->record_document))
                                                    <div class="ml-2 mr-2">
                                                        <a target="_blank"
                                                            href="{{ url('storage/record_document/'. $user_e->record_document) }}"
                                                            download><i class="fa fa-download"></i></a>
                                                    </div>
                                                @endif

                                                @if ($user_e->record_document_approve)
                                                    <span class="checkmark"></span> <span
                                                        style="color:green">Onaylandı</span>
                                                @endif
                                            </label>
                                            <select name="record_document_approve" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->record_document_approve == 0 ? ' selected' : null }}>
                                                    Onaylamıyorum</option>
                                                <option
                                                    value="1"{{ $user_e->record_document_approve == 1 ? ' selected' : null }}>
                                                    Onaylıyorum</option>
                                            </select>
                                        </div>
                                    @endif
                                    @if ($user_e->type == 2 && $user_e->corporate_type == 'Emlakçı')
                                        <div class="form-group">
                                            <label for="kimlik_belgesi" class="mb-2 d-flex align-items-center">Taşınmaz
                                                Yetki Belgesi:


                                                @if (!is_null($user_e->identity_document))
                                                    <div class="ml-2 mr-2">
                                                        <a target="_blank"
                                                            href="{{ url('storage/identity_document/'. $user_e->identity_document) }}"
                                                            download><i class="fa fa-download"></i></a>
                                                    </div>
                                                @endif

                                                @if ($user_e->identity_document_approve)
                                                    <span class="checkmark"></span> <span
                                                        style="color:green">Onaylandı</span>
                                                @endif
                                            </label>
                                            <select name="identity_document_approve" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->identity_document_approve == 0 ? ' selected' : null }}>
                                                    Onaylamıyorum</option>
                                                <option
                                                    value="1"{{ $user_e->identity_document_approve == 1 ? ' selected' : null }}>
                                                    Onaylıyorum</option>
                                            </select>
                                        </div>
                                    @endif
                                    @if ($user_e->type == 2 && $user_e->corporate_type == 'Turizm')
                                        <div class="form-group">
                                            <label for="kimlik_belgesi" class="mb-2 d-flex align-items-center">Acenta
                                                Belgesi:


                                                @if (!is_null($user_e->identity_document))
                                                    <div class="ml-2 mr-2">
                                                        <a target="_blank"
                                                            href="{{ url('storage/identity_document/'. $user_e->identity_document) }}"
                                                            download><i class="fa fa-download"></i></a>
                                                    </div>
                                                @endif
                                                @if ($user_e->identity_document_approve)
                                                    <span class="checkmark"></span> <span
                                                        style="color:green">Onaylandı</span>
                                                @endif
                                            </label>
                                            <select name="identity_document_approve" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->identity_document_approve == 0 ? ' selected' : null }}>
                                                    Onaylamıyorum</option>
                                                <option
                                                    value="1"{{ $user_e->identity_document_approve == 1 ? ' selected' : null }}>
                                                    Onaylıyorum</option>
                                            </select>
                                        </div>
                                    @endif
                                    @if ($user_e->type == 2 && $user_e->corporate_type == 'İnşaat')
                                        <div class="form-group">
                                            <label for="insaat_belgesi" class="mb-2 d-flex align-items-center">Müteahhitlik
                                                Belgesi (Opsiyonel):

                                                @if (!is_null($user_e->company_document))
                                                    <div class="ml-2 mr-2">
                                                        <a target="_blank"
                                                            href="{{ url('storage/company_document/'. $user_e->company_document) }}"
                                                            download><i class="fa fa-download"></i></a>
                                                    </div>
                                                @else
                                                    <span style="color: red;margin-left:5px"> Belge Yüklenmedi</span>
                                                @endif

                                                @if ($user_e->company_document_approve)
                                                    <span class="checkmark"></span> <span
                                                        style="color:green">Onaylandı</span>
                                                @endif

                                            </label>
                                            <select name="company_document_approve" class="form-control">
                                                <option
                                                    value="0"{{ $user_e->company_document_approve == 0 ? ' selected' : null }}>
                                                    Onaylamıyorum</option>
                                                <option
                                                    value="1"{{ $user_e->company_document_approve == 1 ? ' selected' : null }}>
                                                    Onaylıyorum</option>
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
        }

        .ml-2 {
            margin-left: 5px;
        }

        .mr-2 {
            margin-right: 5px;
        }
    </style>
@endsection
