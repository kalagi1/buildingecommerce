@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <form action="{{ route('institutional.verify-account') }}" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="p-5 bg-white border rounded-3 shadow-lg">
                <div class="form-group">
                    <div class="text-success">
                        @if (!is_null(auth()->user()->tax_document) || !is_null(auth()->user()->record_document))
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

                    @if (auth()->user()->identity_document_approve == 1 && auth()->user()->record_document_approve == 1 && auth()->user()->tax_document_approve == 1)
                    <div class="text-warning mt-2">
                        Hesabınıza hala erişemiyorsanız lütfen <a href="mailto:support@emlaksepeti.com">support@emlaksepeti.com</a> adresinden site yönetici ile iletişime geçin.
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="vergi_levhasi" class="mb-2">Vergi Levhası: @if (auth()->user()->tax_document_approve)
                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                        @else
                            <span class="crossmark"></span> <span style="color:red">Reddedildi</span>
                        @endif

                        @if (!is_null(auth()->user()->tax_document))
                        <div>
                        <a target="_blank" href="{{ route('institutional.get.tax-document') }}" class="btn btn-primary">Vergi Levhasını Gör</a>
                        </div>
                        @endif
                    </label>
                    <input type="file" name="vergi_levhasi" id="vergi_levhasi"
                        class="form-control {{ auth()->user()->tax_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->tax_document_approve ? ' required' : null }} />

                </div>

                <div class="form-group">
                    <label for="sicil_belgesi" class="mb-2">Sicil Belgesi:
                        @if (auth()->user()->record_document_approve)
                            <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                        @else
                            <span class="crossmark"></span> <span style="color:red">Reddedildi</span>
                        @endif

                        @if (!is_null(auth()->user()->record_document))
                        <div>
                        <a   target="_blank"  href="{{ route('institutional.get.record-document') }}" class="btn btn-primary">Sicil Belgesini Gör</a>
                        </div>
                        @endif
                    </label>
                    <input type="file" name="sicil_belgesi" id="sicil_belgesi"
                        class="form-control {{ auth()->user()->record_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->record_document_approve == 0 ? ' required' : null }} />
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
                        <a  target="_blank"  href="{{ route('institutional.get.identity-document') }}" class="btn btn-primary">Kimlik Belgesini Gör</a>
                        </div>
                        @endif
                    </label>
                    <input type="file" name="kimlik_belgesi" id="kimlik_belgesi"
                        class="form-control {{ auth()->user()->identity_document_approve ? ' green-border' : 'red-border' }}"
                        accept=".png,.jpeg,.jpg"{{ auth()->user()->identity_document_approve == 0 ? ' required' : null }} />
                </div>

                @if (auth()->user()->type == 2 &&
                        App\Models\UserPlan::where('user_id', auth()->user()->id)->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')->first()->plan_type == 'İnşaat')
                    <div class="form-group">
                        <label for="insaat_belgesi" class="mb-2">İnşaat Belgesi:
                            @if (auth()->user()->company_document_approve)
                                <span class="checkmark"></span> <span style="color:green">Onaylandı</span>
                            @else
                                <span class="crossmark"></span> <span style="color:red">Reddedildi</span>
                            @endif
                        </label>
                        @if (!is_null(auth()->user()->company_document))
                        <div>
                        <a  target="_blank"  href="{{ route('institutional.get.company-document') }}" class="btn btn-primary mb-2">İnşaat Belgesini Gör</a>
                        </div>
                        @endif
                        <input type="file" name="insaat_belgesi" id="insaat_belgesi"
                            class="form-control {{ auth()->user()->company_document_approve ? ' green-border' : 'red-border' }}"
                            accept=".png,.jpeg,.jpg"{{ auth()->user()->company_document_approve == 0 ? ' required' : null }} />
                    </div>
                @endif


                <div class="form-group">
                    @if (
                        !is_null(auth()->user()->tax_document) ||
                            !is_null(auth()->user()->record_document) ||
                            !is_null(auth()->user()->identity_document))
                        <button type="submit" class="btn btn-primary btn-lg">GÜNCELLE</button>
                    @else
                        <button type="submit" class="btn btn-primary btn-lg">ONAYA GÖNDER</button>
                    @endif
                    <a href="{{ route('index') }}" class="backToHome">
                        <button type="button" class="btn btn-primary btn-lg">Anasayfa'ya Dön <svg viewBox="0 0 24 24" width="20"
                                height="20" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"
                                stroke-linejoin="round" class="css-i6dzq1">
                                <polyline points="9 10 4 15 9 20"></polyline>
                                <path d="M20 4v7a4 4 0 0 1-4 4H4"></path>
                            </svg></button>
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection


@section('css')
    <style>
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
