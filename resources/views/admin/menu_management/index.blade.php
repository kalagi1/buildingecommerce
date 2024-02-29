@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary text-white">Menü Yönetimi</div>
                    <div class="card-body">
                        <form id="frmEdit" class="form-horizontal">
                            <div class="form-group">
                                <label for="text">Menü Başlığı</label>
                                <div class="input-group">
                                    <input type="text" class="form-control item-menu" name="text" id="text"
                                        placeholder="Text">
                                    <div class="input-group-append">
                                        <button type="button" id="myEditor_icon"
                                            class="btn btn-outline-secondary"></button>
                                    </div>
                                </div>
                                <input type="hidden" name="icon" class="item-menu">
                            </div>
                            <div class="form-group">
                                <label for="href">Menü URL</label>
                                <input type="text" class="form-control item-menu" id="href" name="href"
                                    placeholder="URL">
                            </div>
                            <div class="form-group">
                                <label for="target">Biçim</label>
                                <select name="target" id="target" class="form-control item-menu">
                                    <option value="_self">Mevcut Pencere</option>
                                    <option value="_blank">Yeni Sekme</option>
                                    <option value="_top">Üst Düzey Çerçeve</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Tooltip</label>
                                <input type="text" name="title" class="form-control item-menu" id="title"
                                    placeholder="Tooltip">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i
                                class="fas fa-sync-alt"></i> Güncelle</button>
                        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i>
                            Ekle</button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <ul id="myEditor" class="sortableLists list-group">
                </ul>
            </div>

            <div class="col-md-12">
                <button class="save-menu btn btn-primary" class="">Kaydet</button>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery-menu-editor.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/bootstrap-iconpicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script>
        var iconPickerOptions = {
            searchText: "Buscar...",
            labelHeader: "{0}/{1}"
        };
        var sortableListOptions = {
            placeholderCss: {
                'background-color': "#cccccc"
            }
        };
        var editor = new MenuEditor('myEditor', {
            listOptions: sortableListOptions,
            iconPicker: iconPickerOptions,
            maxLevel: 3
        });
        editor.setForm($('#frmEdit'));
        editor.setUpdateButton($('#btnUpdate'));
        $("#btnUpdate").click(function() {
            editor.update();
        });
        $('#btnAdd').click(function() {
            editor.add();
        });

        $.ajax({
            url: "{{ route('admin.get.menu') }}", // Verileri getiren API endpoint'i
            method: 'GET',
            success: function(response) {
                editor.setData(response);
            }
        });


        $('.save-menu').click(function() {
            var menuText = editor.getString();
            menuText = JSON.parse(menuText);

            console.log(menuText.length);
            if (menuText.length == 0) {

            } else {
                $.ajax({
                    url: "{{ route('admin.save.menu') }}", // Verileri getiren API endpoint'i
                    method: 'POST',
                    data: {
                        data: menuText,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        console.log(response)
                    }
                });
            }
        })
        console.log()
    </script>
@endsection
