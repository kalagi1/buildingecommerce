@extends('client.layouts.master')

@section('content')
    <section class="ps-section--account">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ps-section__left">
                        <aside class="ps-widget--account-dashboard">
                            <div class="ps-widget__header">
                                <figure>
                                    <figcaption>{{ Auth::user()->name }}</figcaption>
                                    <p><a href="#">{{ Auth::user()->email }}</a></p>
                                </figure>
                            </div>
                            @php
                                $groupedMenuData = [];

                                foreach ($menuData as $menuItem) {
                                    $label = $menuItem['label'];

                                    // Gruplandırılmış menüyü oluştur
                                    if (!isset($groupedMenuData[$label])) {
                                        $groupedMenuData[$label] = [];
                                    }

                                    // Menü öğesini ilgili gruba ekle
                                    $groupedMenuData[$label][] = $menuItem;
                                }
                            @endphp
                            @foreach ($groupedMenuData as $label => $groupedMenu)
                                <div class="ps-widget__content mt-3">

                                    <ul style="padding: 10px !important">

                                        @php
                                            $isActive = false;
                                        @endphp
                                        {{-- <p class="navbar-vertical-label">{{ $label }}</p> --}}

                                        <li @if ($isActive) class="active" @endif>
                                            <ul style="border:none !important">
                                                @foreach ($groupedMenu as $menuItem)
                                                    @if ($menuItem['visible'])
                                                        @php
                                                            $isActive = request()->is($menuItem['activePath']);
                                                        @endphp
                                                        <li @if ($isActive) class="active" @endif
                                                            style="border:none !important">
                                                            <a href="{{ route($menuItem['url']) }}"><i
                                                                    class="fa fa-{{ $menuItem['icon'] }} pl-3"></i>
                                                                {{ $menuItem['text'] }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                                <li style="border:none !important">
                                                    <a href="{{ route('client.logout') }}" target="_blank"><i
                                                            class="fa fa-sign-out pl-3"></i>
                                                        Çıkış Yap</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                            @endforeach

                    </div>
                    </aside>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="content">
                    <form action="{{ route('client.verify-account') }}" enctype="multipart/form-data" method="POST"
                        class="verify-form">
                        @csrf
                        <div class="p-5 bg-white border rounded-3 shadow-lg verify-modal">
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
                                @if (auth()->user()->identity_document_approve == 1)
                                    <div class="text-warning mt-2">
                                        Hesabınıza hala erişemiyorsanız lütfen <a
                                            href="mailto:support@emlaksepeti.com">support@emlaksepeti.com</a> adresinden
                                        site yönetici
                                        ile iletişime geçin.
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="kimlik_belgesi" class="mb-2">Kimlik Belgesi:
                                    @if (auth()->user()->identity_document)
                                        @if (auth()->user()->identity_document_approve)
                                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                                        @else
                                            <span class="crossmark"></span> <span style="color:red">Onay Aşamasında</span>
                                        @endif
                                    @endif

                                </label>
                                <input type="file" name="kimlik_belgesi" id="kimlik_belgesi"
                                    class="form-control important
                                {{ auth()->user()->identity_document
                                    ? (auth()->user()->identity_document_approve
                                        ? 'green-border'
                                        : 'red-border')
                                    : '' }}"
                                    accept=".png,.jpeg,.jpg"{{ auth()->user()->identity_document_approve == 0 ? ' required' : null }} />
                                    @if (!is_null(auth()->user()->identity_document))
                                    <div>
                                        <a href="{{ route('client.get.identity-document') }}"
                                            class="btn btn-primary mt-2">Görüntüle <i class="fa fa-eye"></i> </a>
                                    </div>
                                @endif
                            </div>


                            <div class="form-group btn-approve-group">
                                @if (!is_null(auth()->user()->identity_document))
                                    <button type="submit" class="ps-btn">GÜNCELLE</button>
                                @else
                                    <button type="submit" class="ps-btn">ONAYA GÖNDER</button>
                                @endif
                                <a href="{{ route('index') }}" class="backToHome">
                                    <button type="button" class="ps-btn">Anasayfa'ya Dön <svg viewBox="0 0 24 24"
                                            width="20" height="20" stroke="currentColor" stroke-width="2"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round"
                                            class="css-i6dzq1">
                                            <polyline points="9 10 4 15 9 20"></polyline>
                                            <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                                        </svg></button>
                                </a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        </div>
    </section>
    <style>
        .btn-approve-group{
            position: absolute;
            bottom: 0
        }
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

        .form-control.important {
            background-color: #fff !important;
            background-clip: padding-box !important;
            display: block !important;
            width: 100% !important;
            padding: .375rem .75rem !important;
            border-radius: .25rem !important;
            height: unset !important;
        }

        .form-control.important::file-selector-button {
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
            margin-left: -7px;
            margin-right: 12px;
            margin-top: -3px;
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

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/account.css') }}" />
@endsection
