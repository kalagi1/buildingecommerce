@extends('client.layouts.master')

@section('content')
    <div class="content">
        <form action="{{ route('client.verify-account') }}" enctype="multipart/form-data" method="POST"
            style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 100000; background: rgba(0,0,0,.2); padding: 96px; -webkit-backdrop-filter: blur(5px);">
            @csrf
            <div class="p-5 bg-white border rounded-3 shadow-lg"
                style="width: 75%; overflow-y: scroll; max-height: 520px; margin: 0 auto;">
                <div class="form-group">
                    <div class="text-success">
                        @if (!is_null(auth()->user()->identity_document))
                            Belgeleriniz gönderildi ve şu anda incelemede. Dilerseniz gönderdiğiniz belgeleri
                            güncelleyebilirsiniz. <br>
                            @if ($user->corporate_account_note)
                             <div style="color: red">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                                Admin Notu: {{ $user->corporate_account_note }}
                             </div>
                            @endif
                        @else
                            Sistemi kullanmaya devam edebilmeniz için hesabınızı doğrulamamız gerekiyor.<br />
                            Lütfen aşağıda istenen belgeleri bize gönderin.
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label for="kimlik_belgesi" class="mb-2">Kimlik Belgesi:
                        @if (auth()->user()->identity_document_approve)
                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                        @else
                            <span class="crossmark"></span> <span style="color:red">Reddedildi</span>
                        @endif

                        @if (!is_null(auth()->user()->identity_document))
                        <div>
                        <a href="{{ route('client.get.identity-document') }}" class="btn btn-primary">Kimlik Belgesini Gör</a>
                        </div>
                        @endif
                    </label>
                    <input type="file" name="kimlik_belgesi" id="kimlik_belgesi"
                        class="form-control important {{ auth()->user()->identity_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->identity_document_approve == 0 ? ' required' : null }} />
                </div>


                <div class="form-group">
                    @if (!is_null(auth()->user()->identity_document))
                        <button type="submit" class="btn btn-primary btn-lg">GÜNCELLE</button>
                    @else
                        <button type="submit" class="btn btn-primary btn-lg">ONAYA GÖNDER</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <style>
        /* Add this to your CSS file */
        .green-border {
            border: 2px solid green !important;
        }

        .red-border {
            border: 2px solid red !important;
        }

        .checkmark::after {
            content: '\2713';
            color: green;
            font-size: 16px;
            margin-left: 5px;
        }

        /* CSS for the "crossmark" icon */
        .crossmark::after {
            content: '✗';
            /* Unicode character for the 'X' symbol */
            color: red;
            /* Color of the crossmark */
            font-size: 16px;
            /* Adjust the font size as needed */
            margin-left: 5px;
            /* Adjust the spacing as needed */
        }

        .form-control.important
        {
            background-color: #fff !important;
            background-clip: padding-box !important;
            display: block !important;
            width: 100% !important;
            padding: .375rem .75rem !important;
        }

        .form-control.important::file-selector-button
        {
            align-items: flex-start;
            appearance: button;
            background-color: rgb(233, 236, 239);
            border-bottom-color: rgb(206, 212, 218);
            border-bottom-style: solid;
            border-bottom-width: 0px;
            border-image-outset: 0;
            border-image-repeat: stretch;
            border-image-slice: 100%;
            border-image-source: none;
            border-image-width: 1;
            border-left-color: rgb(206, 212, 218);
            border-left-style: solid;
            border-left-width: 0px;
            border-right-color: rgb(206, 212, 218);
            border-right-style: solid;
            border-right-width: 1px;
            border-top-color: rgb(206, 212, 218);
            border-top-style: solid;
            border-top-width: 0px;
            box-sizing: border-box;
            color: rgb(33, 37, 41);
            cursor: default;
            display: inline-block;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-feature-settings: normal;
            font-kerning: auto;
            font-optical-sizing: auto;
            font-size: 16px;
            font-size-adjust: none;
            font-stretch: 100%;
            font-style: normal;
            font-variant-alternates: normal;
            font-variant-caps: normal;
            font-variant-east-asian: normal;
            font-variant-ligatures: normal;
            font-variant-numeric: normal;
            font-variant-position: normal;
            font-variation-settings: normal;
            font-weight: 400;
            letter-spacing: normal;
            line-height: 24px;
            margin-bottom: -6px;
            margin-left: -11px;
            margin-right: 12px;
            margin-top: -6px;
            padding-bottom: 2px;
            padding-left: 12px;
            padding-right: 12px;
            padding-top: 6px;
            text-align: center;
            text-indent: 0px;
            text-shadow: none;
            text-transform: none;
            white-space: nowrap;
            word-spacing: 0px;
            writing-mode: horizontal-tb;
            -webkit-rtl-ordering: logical;
            -webkit-user-select: text;
        }
    </style>
@endsection