@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h3 class="mb-2 lh-sm">Kupon Kodu Tanımla</h3>
        <div class="mt-1">
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

                                    <form class="row g-3 needs-validation" novalidate="" method="POST"
                                        action="{{ route('admin.estate.create.coupon.store.all.users') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12">
                                            <label class="form-label" for="users">Kuponu Kullanabilecek Kullanıcılar</label>
                                            <div class="">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" id="userSearch" placeholder="Kullanıcı Ara">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Ara</button>
                                                </div>
                                                <select name="users[]" class="form-control mb-3" id="users" multiple required>
                                                    @foreach($estateClubUsers as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="selectAllUsers">
                                                    <label class="form-check-label" for="selectAllUsers">Tümünü Seç</label>
                                                </div>
                                            </div>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="code">Kupon Kodu</label>
                                            <input name="code" class="form-control" id="code" type="text" value="" required>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="code">Kullanım Sayısı</label>
                                            <input name="use_count" class="form-control price-only" id="code" type="text" value="" required>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="discount_type">Satın Alan Kişiye Uygulanacak İndirimin Tipi</label>
                                            <select name="discount_type" class="form-control" id="discount_type" required>
                                                <option value="">Satın Alan Kişiye Uygulanacak İndirimin Tipini Seç</option>
                                                <option value="1">Yüzdesel</option>
                                                <option value="2">Miktar Olarak</option>
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="discount_type">Satın Alan Kişiye Uygulanacak İndirim Miktarı</label>
                                            <div class="right-icon-input">
                                                <input type="text" name="buyer_amount" class="price-only">
                                                <span class="right-icon amount-icon">?</span>
                                            </div>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="discount_type">Emlak Kulüp Üyesine Sağlanacak Karın Tipi</label>
                                            <select name="estate_club_user_amount_type" class="form-control" id="estate_club_user_amount_type" required>
                                                <option value="">Emlak Kulüp Üyesine Sağlanacak Karın Tipi</option>
                                                <option value="1">Satıştan Yüzde</option>
                                                <option value="2">Miktar</option>
                                            </select>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="discount_type">Emlak Kulüp Üyesine Verilecek Miktar</label>
                                            <div class="right-icon-input">
                                                <input name="estate_club_user_amount" type="text" class="price-only">
                                                <span class="right-icon estate_amount-icon">?</span>
                                            </div>
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="" style="font-size: 14px;"><b>Kupon kullanım süresi</b></label>
                                            <div class="d-flex">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input date_fix_input" value="1" name="date_fix" id="forever" type="radio" />
                                                    <label class="form-check-label" for="forever">Sınırsız</label>
                                                </div>
                                                <div class="form-check form-switch mx-4">
                                                    <input class="form-check-input date_fix_input" value="2" name="date_fix" id="date_limit" type="radio" />
                                                    <label class="form-check-label" for="date_limit">Belirli tarihler arasında</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none date_fix_area">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label" for="start_date">Bu kupon kodunun uygulanmasının başlangıç tarihi</label>
                                                    <input name="start_date" class="form-control" id="start_date" type="date" value="" >
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" for="end_date">Bu kupon kodunun uygulanmasının bitiş tarihi</label>
                                                    <input name="end_date" class="form-control" id="end_date" type="date" value="" >
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <label for="" style="font-size: 14px;"><b>Kupon hangi projelerde kullanılabilir</b></label>
                                                <div class="d-flex">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input select_project_checkox" value="1" name="select_project_check" id="all_projects" type="radio" />
                                                        <label class="form-check-label" for="all_projects">Tüm Projelerde</label>
                                                    </div>
                                                    <div class="form-check form-switch mx-4">
                                                        <input class="form-check-input select_project_checkox" value="2" name="select_project_check" id="select_projects_checkbox" type="radio" />
                                                        <label class="form-check-label" for="select_projects_checkbox">Belirli Projelerde</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input select_project_checkox" value="3" name="select_project_check" id="non_select_projects_checkbox" type="radio" />
                                                        <label class="form-check-label" for="non_select_projects_checkbox">Hiçbir Projede</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none select_projects_area mt-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select name="projects[]" id="organizerSingle" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}' class="form-control" multiple id="">
                                                            <option value="" >Projeleri Seçiniz</option>
                                                            @foreach($projects as $project)
                                                                <option value="{{$project->id}}">{{$project->project_title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <label for="" style="font-size: 14px;"><b>Kupon hangi emlaklarda kullanılabilir</b></label>
                                                <div class="d-flex">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input select_housing_checkox" value="1" name="select_housing_check" id="all_housings" type="radio" />
                                                        <label class="form-check-label" for="all_housings">Tüm Emlaklarda</label>
                                                    </div>
                                                    <div class="form-check form-switch mx-4">
                                                        <input class="form-check-input select_housing_checkox" value="2" name="select_housing_check" id="select_housings_checkbox" type="radio" />
                                                        <label class="form-check-label" for="select_housings_checkbox">Belirli Emlaklarda</label>
                                                    </div>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input select_housing_checkox" value="3" name="select_housing_check" id="non_select_housings_checkbox" type="radio" />
                                                        <label class="form-check-label" for="non_select_housings_checkbox">Hiçbir Emlakda</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-none select_housings_area mt-3">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select name="housings[]" id="organizerSingle" data-choices="data-choices" data-options='{"removeItemButton":true,"placeholder":true}' class="form-control" multiple id="">
                                                            <option value="" >Emlakları Seçiniz</option>
                                                            @foreach($housings as $housing)
                                                                <option value="{{$housing->id}}">{{$housing->title}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const selectAllUsersCheckbox = document.getElementById('selectAllUsers');
    const usersSelect = document.getElementById('users');
    const userSearchInput = document.getElementById('userSearch');
    const searchButton = document.getElementById('searchButton');

    selectAllUsersCheckbox.addEventListener('change', function() {
        const isChecked = this.checked;
        const options = usersSelect.options;

        for (let i = 0; i < options.length; i++) {
            options[i].selected = isChecked;
        }
    });

    function filterUsers() {
        const searchTerm = userSearchInput.value.toLowerCase();

        for (let i = 0; i < usersSelect.options.length; i++) {
            const optionText = usersSelect.options[i].text.toLowerCase();
            const isMatch = optionText.includes(searchTerm);
            usersSelect.options[i].hidden = !isMatch;
        }
    }

    searchButton.addEventListener('click', filterUsers);

    userSearchInput.addEventListener('input', filterUsers);
});

</script>
    <script>
        $('#discount_type').change(function(){
            if($(this).val() == 1){
                $('.amount-icon').html('%');
            }else if($(this).val() == 2){
                $('.amount-icon').html('₺');
            }else{
                $('.amount-icon').html('?');
            }
        });

        $('#estate_club_user_amount_type').change(function(){
            if($(this).val() == 1){
                $('.estate_amount-icon').html('%');
            }else if($(this).val() == 2){
                $('.estate_amount-icon').html('₺');
            }else{
                $('.estate_amount-icon').html('?');
            }
        });

        $('.price-only').keyup(function(){
            if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                if($(this).closest('.form-group').find('.error-text').length > 0){
                    $(this).val("");
                }else{
                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $(this).val("");
                }
                
            }else{
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(inputValue)
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })

        $('.date_fix_input').change(function(){
            if($(this).val() == 2){
                $('.date_fix_area').removeClass('d-none')
            }else{
                $('.date_fix_area').addClass('d-none')
            }
        })

        $('.select_project_checkox').change(function(){
            if($(this).val() == 2){
                $('.select_projects_area').removeClass('d-none')
            }else{
                $('.select_projects_area').addClass('d-none')
            }
        })

        $('.select_housing_checkox').change(function(){
            if($(this).val() == 2){
                $('.select_housings_area').removeClass('d-none')
            }else{
                $('.select_housings_area').addClass('d-none')
            }
        })
    </script>
@endsection
