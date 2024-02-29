@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300 p-0 " data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">
                              Alt Kullanıcı Ekle
                            </h4>

                        </div>
                    </div>
                </div>
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

                        <form class="row g-3 needs-validation" novalidate="" method="POST"
                            action="{{ route('institutional.users.store') }}">
                            @csrf
                            <div class="col-md-12">
                                <label class="form-label" for="name">İsim Soyisim</label>
                                <input name="name" class="form-control" id="name" type="text" value=""
                                    required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="email">Email</label>
                                <input name="email" class="form-control" id="email" type="email" value=""
                                    required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="password">Şifre</label>
                                <input name="password" class="form-control" id="password" type="password" value=""
                                    required="">
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="validationCustom04">Kullanıcı Tipi</label>
                                <select name="type" class="form-select" id="validationCustom04" required="">
                                    <option selected disabled value="">Seç...</option>

                                    @foreach ($roles as $item)
                                        <option value={{ $item->id }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="is_active" id="flexSwitchCheckCheckedDisabled"
                                        type="checkbox" checked="" />
                                    <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Aktif</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Kaydet</button>
                            </div>
                        </form>

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
@section('scripts')
    <script>
        jQuery(function($) {
            var options = {
                onSave: function(evt, formData) {
                    document.getElementById("form_json").value = (formData);
                    console.log(JSON.stringify(formData))
                },
            };

            $(document.getElementById('fb-editor')).formBuilder(options);

        });
    </script>
@endsection
