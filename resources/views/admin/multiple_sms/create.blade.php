@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300  p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Sms Oluştur</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if (session('success'))
                        <div class="alert alert-success" style="margin: 30px 30px 0 30px;color:white !important">
                            {{ session('success') }}
                        </div>
                    @else
                        <div class="alert alert-error" style="margin: 30px 30px 0 30px;color:white !important">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger text-white">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="p-4 code-to-copy">
                        <form action="{{ route('admin.multiple_sms.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="userType">Kullanıcı Türü</label>
                                <select class="form-select" name="userType" id="userType">
                                    <option value=""> Kullanıcı Tipi Seç</option>
                                    <option value="all">Tüm Kullanıcılar</option>
                                    <option value="individual">Bireysel Kullanıcılar</option>
                                    <option value="corporate">Kurumsal Kullanıcılar</option>
                                </select>
                            </div>
                            <div id="userList" style="display: none;">
                                <div id="userCheckboxes">
                                    <input type="checkbox" id="selectAll"> <label for="selectAll">Tümünü Seç</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="content">Sms İçeriği</label>
                                <textarea class="form-control" id="editor" name="content" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Toplu Sms Oluştur</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script></script>
    <script>
        $(document).ready(function() {

            $('#userType').change(function() {
                var userType = $(this).val();

                // Önceki kullanıcı listesini temizle
                $('#userCheckboxes').empty();

                var selectAllCheckbox =
                    '<div class="form-check form-switch" style="margin-left:14px;"><input class="form-check-input" type="checkbox" role="switch"  id="selectAll" style="font-size: 22px;color: #333;margin-bottom: 12px;"> <label for="selectAll" style="margin-top:6px;font-size: 15px;color: #333;margin-bottom: 12px;">Tümünü Seç</label></div>';
                $('#userCheckboxes').html(selectAllCheckbox);


                $('#selectAll').click(function() {
                    $('input[class="userCheck"]').prop('checked', $(this).prop('checked'));
                });

                if (userType === '') {
                    $('#userList').hide();
                    return; // Kullanıcı tipi seçilmediyse işlemi sonlandır
                }

                $('#userList').show();

                var url;

                if (userType === 'individual') {
                    url = '/multiple-mail/get/users/bireysel';
                } else if (userType === 'corporate') {
                    url = '/multiple-mail/get/users/kurumsal';
                } else if (userType === 'all') {
                    url = '/multiple-mail/get/users';
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var users = response;

                        users.forEach(function(user) {
                            $('#users').append('<option value="' + user.id + '">' + user
                                .name + '</option>');
                        });

                        var userCount = users.length;
                        var rowCount = Math.ceil(userCount / 3);

                        for (var i = 0; i < rowCount; i++) {
                            var $row = $('<div class="row mb-3">');
                            for (var j = i * 3; j < Math.min((i + 1) * 3, userCount); j++) {
                                $row.append(
                                    '<div class="col-md-4"><input class="userCheck" type="checkbox" name="selectedUsers[]" style="margin-right:6px;" value="' +
                                    users[j].id + '"><label>' + users[j].name +
                                    '</label></div>');
                            }
                            $('#userCheckboxes').append($row);
                        }
                    }
                });
            });
        });
    </script>

    @stack('scripts')
@endsection

@section('css')
    <style>
    </style>
@endsection
