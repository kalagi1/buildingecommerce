@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <form action="{{ route('institutional.verify-account') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="p-5 bg-white border rounded-3 shadow-lg">
                <div class="form-group">
                    <div class="text-success">
                        @if (!is_null(auth()->user()->tax_document) || !is_null(auth()->user()->record_document))
                            Belgeleriniz gönderildi. En geç 12 saat içerisinde inceleme sonucu tarafınıza
                            iletilecektir.
                            Dilerseniz gönderdiğiniz belgeleri
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

                    @if (auth()->user()->identity_document_approve == 1 &&
                            auth()->user()->record_document_approve == 1 &&
                            auth()->user()->tax_document_approve == 1)
                        <div class="text-warning mt-2">
                            Hesabınıza hala erişemiyorsanız lütfen <a
                                href="mailto:support@emlaksepette.com">support@emlaksepette.com</a> adresinden site yönetici
                            ile iletişime geçin.
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="vergi_levhasi" class="mb-2">İmza Sirküsü: @if (auth()->user()->tax_document_approve)
                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                        @endif

                        @if (!is_null(auth()->user()->tax_document))
                            <div>
                                <a target="_blank" href="{{ route('institutional.get.tax-document') }}"
                                    class="btn btn-blue">İmza Sirküsünü Gör</a>
                            </div>
                        @endif
                    </label>
                    <input type="file" name="vergi_levhasi" id="vergi_levhasi"
                        class="form-control {{ auth()->user()->tax_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->tax_document_approve ? ' ' : null }} />

                </div>

                <div class="form-group">
                    <label for="sicil_belgesi" class="mb-2">Vergi Levhası:
                        @if (auth()->user()->record_document_approve)
                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                        @endif

                        @if (!is_null(auth()->user()->record_document))
                            <div>
                                <a target="_blank" href="{{ route('institutional.get.record-document') }}"
                                    class="btn btn-blue">Vergi Levhasını Gör</a>
                            </div>
                        @endif
                    </label>
                    <input type="file" name="sicil_belgesi" id="sicil_belgesi"
                        class="form-control {{ auth()->user()->record_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->record_document_approve == 0 ? ' ' : null }} />
                </div>
                <div class="form-group">
                    <label for="kimlik_belgesi" class="mb-2">Yetkilinin Kimlik Belgesi:
                        @if (auth()->user()->identity_document_approve)
                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                        @endif

                        @if (!is_null(auth()->user()->identity_document))
                            <div>
                                <a target="_blank" href="{{ route('institutional.get.identity-document') }}"
                                    class="btn btn-blue">Yetkilinin Kimlik Belgesini Gör</a>
                            </div>
                        @endif
                    </label>
                    <input type="file" name="kimlik_belgesi" id="kimlik_belgesi"
                        class="form-control {{ auth()->user()->identity_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->identity_document_approve == 0 ? ' ' : null }} />
                </div>

                @if (auth()->user()->type == 2 && auth()->user()->corporate_type == 'İnşaat')
                    <div class="form-group">
                        <label for="insaat_belgesi" class="mb-2">Müteahhitlik Belgesi:
                            @if (auth()->user()->company_document_approve)
                                <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                            @endif
                        </label>
                        @if (!is_null(auth()->user()->company_document))
                            <div>
                                <a target="_blank" href="{{ route('institutional.get.company-document') }}"
                                    class="btn btn-blue mb-2">Müteahhitlik Belgesini Gör</a>
                            </div>
                        @endif
                        <input type="file" name="insaat_belgesi" id="insaat_belgesi"
                            class="form-control {{ auth()->user()->company_document_approve ? ' green-border' : 'red-border' }}"
                            accept=".png,.jpeg,.jpg"{{ auth()->user()->company_document_approve == 0 ? ' ' : null }} />
                    </div>
                @endif


                <div class="form-group">
                    @if (
                        !is_null(auth()->user()->tax_document) ||
                            !is_null(auth()->user()->record_document) ||
                            !is_null(auth()->user()->identity_document))
                        <button type="submit" class="btn btn-primary">GÜNCELLE</button>
                    @else
                        <button type="submit" class="btn btn-primary">ONAYA GÖNDER</button>
                    @endif
                    <a href="{{ route('index') }}" class="backToHome">
                        <button type="button" class="btn btn-primary">Anasayfa'ya Dön </button>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('css')
    <style>
        .btn-blue {
            background-color: #0080c7 !important;
            color: white
        }

        /* Add this to your CSS file */
        .green-border {
            border: 2px solid green;
        }

        .red-border {
            border: 2px solid #EA2B2E;
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
            color: #EA2B2E;
            /* Color of the crossmark */
            font-size: 16px;
            /* Adjust the font size as needed */
            margin-left: 5px;
            /* Adjust the spacing as needed */
        }
    </style>
@endsection
