@extends('admin.layouts.master')
@section('content')
    <div class="content">
        <div class="row">
            <div class="row justify-content-between mb-4  align-items-center">
                <div class="col-auto">
                    <h2 class="mb-0">Site Ayarları
                    </h2>
                </div>
                <div class="col-auto">
                    <div class="col-auto">
                        <button class="btn btn-primary" id="newSetting">
                            <i class="fa-solid fa-plus me-2"></i> Yeni Ekle</button>

                    </div>
                </div>
            </div>




            <div class="table-responsive">

                @if (session()->has('alertSuccessMessage'))
                    <div class="alert alert-success text-white">
                        {{ session()->get('alertSuccessMessage') }}
                    </div>
                @endif
                <table class="table table-bordered table-hover table-condensed mb-4">
                    <thead>
                        <tr id="settingTableHeader">
                            <th>Anahtar</th>
                            <th>Değer</th>
                            <th>Sil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($settings as $setting)
                            <tr>
                                <td>{{ $setting->key }}</td>
                                <td> <input class="form-control settingInput" type="text" value="{{ $setting->value }}"
                                        name="{{ $setting->key }}"></td>
                                <td><button class="btn btn-outline-danger mb-2 settingDelete"
                                        data-key="{{ $setting->key }}">Sil</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".settingInput").on("change", function() {
                var input = $(this);
                $.ajax({
                    type: "POST",
                    url: "{{ url('1a2b3c4d5e6f/secured/site-settings/update') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        key: input.attr("name"),
                        value: input.val()
                    },

                    success: function(response) {
                        location.reload();
                    }
                });
            });

            $("#newSetting").click(function() {
                var data = "<tr>\n" +
                    "<td> <input class=\"form-control\" type=\"text\" name=\"key\" id='newSettingKey'></td>" +
                    "<td> <input class=\"form-control\" type=\"text\" name=\"key\" id='newSettingValue'></td>" +
                    "</tr>";

                $("#settingTableHeader").after(data);
            });

            var key = false;
            var value = false;

            $(document).on("change", "#newSettingKey", function() {
                if ($(this).val().length > 0 && $("#newSettingValue").val().length > 0) {
                    newSetting()
                }
            });
            $(document).on("change", "#newSettingValue", function() {
                if ($(this).val().length > 0 && $("#newSettingKey").val().length > 0) {
                    newSetting()
                }
            });


            function newSetting() {
                var key = $("#newSettingKey").val();
                var value = $("#newSettingValue").val();
                $.ajax({
                    type: "post",
                    url: "{{ url('1a2b3c4d5e6f/secured/site-settings/create') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        key: key,
                        value: value
                    },
                    success: function(response) {
                        location.reload();
                    }
                })
            };

            $(".settingDelete").click(function() {
                var button = $(this);
                $.ajax({
                    type: "post",
                    url: "{{ url('1a2b3c4d5e6f/secured/site-settings/delete') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        key: button.data("key")
                    },
                    success: function(response) {
                        button.closest("tr").remove();
                        location.reload();
                    },
                    error: function(response) {}

                });
            });
        });
    </script>
@endsection
