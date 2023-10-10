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
                                    <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Üye
                                        Düzenle</h4>
                                </div>
                            </div>
                        </div>
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
                                <form action="{{route('admin.update-corporate-status', ['user' => $user_e->id])}}" method="POST" class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            @csrf
                                            <label>Belge Onay Durumu:</label>
                                            <img src="{{ route('admin.get.tax-document', ['user' => $user_e->id]) }}" width="100%" height="480px" class="rounded-3" style="object-fit: contain;"/>
                                            <select name="tax_document_approve" class="form-control">
                                                <option value="0"{{$user_e->tax_document_approve == 0 ? ' selected' : null}}>Vergi Levhasını Onaylamıyorum</option>
                                                <option value="1"{{$user_e->tax_document_approve == 1 ? ' selected' : null}}>Vergi Levhasını Onaylıyorum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <img src="{{ route('admin.get.record-document', ['user' => $user_e->id]) }}" width="100%" height="480px" class="rounded-3" style="object-fit: contain;"/>
                                            <select name="record_document_approve" class="form-control">
                                                <option value="0"{{$user_e->record_document_approve == 0 ? ' selected' : null}}>Sicil Belgesini Onaylamıyorum</option>
                                                <option value="1"{{$user_e->record_document_approve == 1 ? ' selected' : null}}>Sicil Belgesini Onaylıyorum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <img src="{{ route('admin.get.identity-document', ['user' => $user_e->id]) }}" width="100%" height="480px" class="rounded-3" style="object-fit: contain;"/>
                                            <select name="identity_document_approve" class="form-control">
                                                <option value="0"{{$user_e->identity_document_approve == 0 ? ' selected' : null}}>Kimlik Belgesini Onaylamıyorum</option>
                                                <option value="1"{{$user_e->identity_document_approve == 1 ? ' selected' : null}}>Kimlik Belgesini Onaylıyorum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <img src="{{ route('admin.get.company-document', ['user' => $user_e->id]) }}" width="100%" height="480px" class="rounded-3" style="object-fit: contain;"/>
                                            <select name="company_document_approve" class="form-control">
                                                <option value="0"{{$user_e->company_document_approve == 0 ? ' selected' : null}}>İnşaat Belgesini Onaylamıyorum</option>
                                                <option value="1"{{$user_e->company_document_approve == 1 ? ' selected' : null}}>İnşaat Belgesini Onaylıyorum</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="note">Not:</label>
                                            <textarea name="note" id="note" rows="5" class="form-control">{{$user_e->corporate_account_note}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Durum:</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="0"{{$user_e->corporate_account_status == 0 ? ' selected' : null}}>Onaylanmadı</option>
                                                <option value="1"{{$user_e->corporate_account_status == 1 ? ' selected' : null}}>Onaylandı</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-lg">Firma Onayını Güncelle</button>
                                        </div>
                                    </div>
                                </form>
                                <form class="row g-3 needs-validation" novalidate="" method="POST"
                                    action="{{ route('admin.users.update', $user_e->id) }}">
                                    @csrf
                                    @method('PUT') <!-- HTTP PUT kullanarak güncelleme işlemi yapılacak -->

                                    <div class="col-md-12">
                                        <label class="form-label" for="name">İsim Soyisim</label>
                                        <input name="name" class="form-control" id="name" type="text"
                                            value="{{ old('name', $user_e->name) }}" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="email">Email</label>
                                        <input name="email" class="form-control" id="email" type="email"
                                            value="{{ old('email', $user_e->email) }}" required="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="password">Şifre (Değiştirmek istemiyorsanız boş
                                            bırakın)</label>
                                        <input name="password" class="form-control" id="password" type="password"
                                            value="">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="validationCustom04">Kullanıcı Tipi</label>
                                        <select name="type" class="form-select" id="validationCustom04" required="">
                                            @foreach ($roles as $item)
                                                <option value={{ $item->id }}
                                                    {{ old('type', $user_e->type) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" name="is_active"
                                                id="flexSwitchCheckCheckedDisabled" type="checkbox"
                                                {{ old('is_active', $user_e->status) ? 'checked' : '' }} />
                                            <label class="form-check-label"
                                                for="flexSwitchCheckCheckedDisabled">Aktif</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        @if (in_array('UpdateUser', $userPermissions))
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        @else
                                            <p>Bu işlem için yetkiniz yok</p>
                                        @endif
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
        <footer class="footer position-absolute">
            <div class="row g-0 justify-content-between align-items-center h-100">
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span
                            class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br
                            class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a>
                    </p>
                </div>
                <div class="col-12 col-sm-auto text-center">
                    <p class="mb-0 text-600">v1.13.0</p>
                </div>
            </div>
        </footer>
    </div>
@endsection
