@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300  p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">SMTP Güncelle</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                  
                    <div class="p-4 code-to-copy">
                        @if (session('success'))
                        <div class="alert alert-success text-white text-white">
                            {{ session('success') }}
                        </div>
                    @endif
                        <form action="{{ route('admin.smtp.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="smtp_server">SMTP Sunucusu</label>
                                <input type="text" name="smtp_server" id="smtp_server" class="form-control"
                                    value="{{ $smtpSettings->smtp_server }}">
                            </div>

                            <div class="form-group">
                                <label for="smtp_port">SMTP Port</label>
                                <input type="text" name="smtp_port" id="smtp_port" class="form-control"
                                    value="{{ $smtpSettings->smtp_port }}">
                            </div>

                            <div class="form-group">
                                <label for="smtp_username">SMTP Kullanıcı Adı</label>
                                <input type="text" name="smtp_username" id="smtp_username" class="form-control"
                                    value="{{ $smtpSettings->smtp_username }}">
                            </div>

                            <div class="form-group">
                                <label for="smtp_password">SMTP Şifre</label>
                                <input type="password" name="smtp_password" id="smtp_password" class="form-control"
                                    value="{{ $smtpSettings->smtp_password }}">
                            </div>

                            <button type="submit" class="btn btn-primary">Ayarları Güncelle</button>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    @endsection
