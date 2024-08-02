@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb mb-5">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Alt Kullanıcı Ekle
            </li>
        </ul>
    </div>
    <section>
        <div class="single homes-content details mb-30">

            <div class="container">
                <form class="row g-3 needs-validation" novalidate="" method="POST"
                    action="{{ route('institutional.users.store') }}">
                    @csrf
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="name">İsim Soyisim</label>
                        <input name="name" class="form-control" id="name" type="text" placeholder="İsim Soyisim">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="name">Unvan</label>
                        <input name="title" class="form-control" id="title" type="text" placeholder="Unvan">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input name="email" class="form-control" id="email" type="email" placeholder="Email">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="phone">Telefon</label>
                        <input type="number" name="mobile_phone" id="phone"
                            class="form-control {{ $errors->has('mobile_phone') ? 'error-border' : '' }}"
                            value="{{ old('mobile_phone') }}" placeholder="Telefon">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="password">Şifre</label>
                        <input name="password" class="form-control" id="password" type="password" placeholder="Şifre">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="validationCustom04">Kullanıcı Tipi</label>
                        <select name="type" class="form-select" id="validationCustom04" required="">
                            <option selected disabled value="">Seç...</option>

                            @foreach ($roles as $item)
                                <option value={{ $item->id }}>{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
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
