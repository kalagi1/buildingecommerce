@extends('client.layouts.masterPanel')

@section('content')
    <div class="table-breadcrumb">
        <ul>
            <li>
                Hesabım
            </li>
            <li>
                Alt Kullanıcı Düzenle
            </li>
            <li>{{ $subUser->name }}</li>
        </ul>
    </div>
    <section>
        <div class="single homes-content details mb-30">

            <div class="container">
                <form class="row g-3 needs-validation" novalidate="" method="POST"
                    action="{{ route('institutional.users.update', hash_id($subUser->id)) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')


                    <div class="col-lg-12">
                        <div>
                            <input class="d-none" id="upload-settings-porfile-picture" name="profile_image" type="file"
                                accept=".jpeg, .jpg, .png"><label class="avatar avatar-4xl status-online cursor-pointer"
                                for="upload-settings-porfile-picture">
                                @if ($subUser->profile_image == 'indir.png')
                                    @php
                                        $nameInitials = collect(preg_split('/\s+/', $subUser->name))
                                            ->map(function ($word) {
                                                return mb_strtoupper(mb_substr($word, 0, 1));
                                            })
                                            ->take(1)
                                            ->implode('');
                                    @endphp

                                    <div class="profile-initial">{{ $nameInitials }}</div>
                                @else
                                    @php
                                        $imagePath = 'profile_images/' . $subUser->profile_image;
                                        $defaultImage = 'storage/profile_images/indir.png';
                                    @endphp

                                    @if (Storage::disk('public')->exists($imagePath))
                                        <img loading="lazy" src="{{ asset('storage/' . $imagePath) }}"
                                            alt="{{ $subUser->name }}"
                                            class="rounded-circle img-thumbnail shadow-sm border-0"
                                            style="object-fit:contain;" width="100">
                                    @else
                                        <img loading="lazy" src="{{ asset($defaultImage) }}" alt="{{ $subUser->name }}"
                                            class="rounded-circle img-thumbnail shadow-sm border-0"
                                            style="object-fit:contain;" width="100">
                                    @endif
                                @endif

                            </label>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="name">İsim Soyisim</label>
                        <input name="name" class="form-control" id="name" type="text"
                            value="{{ $subUser->name }}" required="">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="name">Unvan</label>
                        <input name="title" class="form-control" value="{{ $subUser->title }}" id="title"
                            type="text" value="" required="">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input name="email" class="form-control" id="email" type="email"
                            value="{{ $subUser->email }}" required="">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="phone">Cep No</label>
                        <input name="mobile_phone" class="form-control" id="phone" type="number"
                            value="{{ $subUser->mobile_phone }}" required="">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="password">Şifre (Değiştirmek istemiyorsanız boş
                            bırakın)</label>
                        <input name="password" class="form-control" id="password" type="password" value="">
                        <div class="valid-feedback">İyi Görünüyor !</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="status"></label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="project_authority" checked onchange="toggleProjectAuthorityLabel()">
                            <label class="form-check-label" id="projectAuthorityLabel" for="flexSwitchCheckChecked">Proje Atama Yetkisi Verildi</label>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label" for="validationCustom04">Kullanıcı Tipi</label>
                        <select name="type" class="form-select" id="validationCustom04" required="">
                            @foreach ($roles as $item)
                                <option value={{ $item->id }} {{ $subUser->type == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3 mb-3">

                        <div class="checkboxes float-left">
                            <div class="filter-tags-wrap">
                                <input id="check-c" type="checkbox" name="is_active"
                                    {{ $subUser->status == 5 ? 'checked' : '' }}>
                                <label for="check-c">Kullanıcıyı Engelle</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        @if (in_array('UpdateUser', $userPermissions))
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    function toggleProjectAuthorityLabel() {
        var checkbox = document.getElementById("flexSwitchCheckChecked");
        var label = document.getElementById("projectAuthorityLabel");
        if (checkbox.checked) {
            label.textContent = "Proje Atama Yetkisi Verildi";
        } else {
            label.textContent = "Proje Atama Yetkisi Ver";
        }
    }
</script>
    
@endsection