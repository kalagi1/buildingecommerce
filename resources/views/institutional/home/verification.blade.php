@extends('institutional.layouts.master')


@section('content')
    <div class="content">
        <form action="{{route('institutional.verify-account')}}" enctype="multipart/form-data" method="POST" style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: 100000; background: rgba(0,0,0,.2); padding: 96px; -webkit-backdrop-filter: blur(5px);">
            @csrf
            <div class="p-5 bg-white border rounded-3 shadow-lg" style="width: 75%; overflow-y: scroll; max-height: 520px; margin: 0 auto;">
                <div class="form-group">
                    <div class="alert alert-outline-success">
                        @if (!is_null(auth()->user()->tax_document) || !is_null(auth()->user()->record_document))
                        Belgeleriniz gönderildi ve şu anda incelemede. Dilerseniz gönderdiğiniz belgeleri güncelleyebilirsiniz.
                        @else
                        Sistemi kullanmaya devam edebilmeniz için hesabınızı doğrulamamız gerekiyor.<br/>
                        Lütfen aşağıda istenen belgeleri bize gönderin.
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    @if (auth()->user()->tax_document_approve)
                    <div class="alert alert-outline-info mt-3">
                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path style="fill: var(--phoenix-info-500);" d="M7 5c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h10c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2H7zm0 12V7h10l.002 10H7z"/><path style="fill: var(--phoenix-info-500);" d="M10.996 12.556 9.7 11.285l-1.4 1.43 2.704 2.647 4.699-4.651-1.406-1.422z"/></svg>
                        Vergi levhanız onaylandı.
                    </div>
                    @endif
                    <label for="vergi_levhasi" class="mb-2">Vergi Levhası:</label>
                    <input type="file" name="vergi_levhasi" id="vergi_levhasi" class="form-control" accept=".png,.jpeg,.jpg"{{auth()->user()->tax_document_approve == 0 ? ' required' : null}}/>
                </div>
                <div class="form-group">
                    @if (auth()->user()->record_document_approve)
                    <div class="alert alert-outline-info mt-3">
                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path style="fill: var(--phoenix-info-500);" d="M7 5c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h10c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2H7zm0 12V7h10l.002 10H7z"/><path style="fill: var(--phoenix-info-500);" d="M10.996 12.556 9.7 11.285l-1.4 1.43 2.704 2.647 4.699-4.651-1.406-1.422z"/></svg>
                        Sicil belgeniz onaylandı.
                    </div>
                    @endif
                    <label for="sicil_belgesi" class="mb-2">Sicil Belgesi:</label>
                    <input type="file" name="sicil_belgesi" id="sicil_belgesi" class="form-control" accept=".png,.jpeg,.jpg"{{auth()->user()->record_document_approve == 0 ? ' required' : null}}/>
                </div>
                <div class="form-group">
                    @if (auth()->user()->identity_document_approve)
                    <div class="alert alert-outline-info mt-3">
                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path style="fill: var(--phoenix-info-500);" d="M7 5c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h10c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2H7zm0 12V7h10l.002 10H7z"/><path style="fill: var(--phoenix-info-500);" d="M10.996 12.556 9.7 11.285l-1.4 1.43 2.704 2.647 4.699-4.651-1.406-1.422z"/></svg>
                        Kimlik belgeniz onaylandı.
                    </div>
                    @endif
                    <label for="kimlik_belgesi" class="mb-2">Kimlik Belgesi:</label>
                    <input type="file" name="kimlik_belgesi" id="kimlik_belgesi" class="form-control" accept=".png,.jpeg,.jpg"{{auth()->user()->identity_document_approve == 0 ? ' required' : null}}/>
                </div>
                @if (auth()->user()->type == 2 && App\Models\UserPlan::where('user_id', auth()->user()->id)->join('subscription_plans', 'subscription_plans.id', '=', 'user_plans.subscription_plan_id')->first()->plan_type == 'İnşaat')
                <div class="form-group">
                    @if (auth()->user()->company_document_approve)
                    <div class="alert alert-outline-info mt-3">
                        <svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path style="fill: var(--phoenix-info-500);" d="M7 5c-1.103 0-2 .897-2 2v10c0 1.103.897 2 2 2h10c1.103 0 2-.897 2-2V7c0-1.103-.897-2-2-2H7zm0 12V7h10l.002 10H7z"/><path style="fill: var(--phoenix-info-500);" d="M10.996 12.556 9.7 11.285l-1.4 1.43 2.704 2.647 4.699-4.651-1.406-1.422z"/></svg>
                        İnşaat belgeniz onaylandı.
                    </div>
                    @endif
                    <label for="insaat_belgesi" class="mb-2">İnşaat Belgesi:</label>
                    <input type="file" name="insaat_belgesi" id="insaat_belgesi" class="form-control" accept=".png,.jpeg,.jpg"{{auth()->user()->company_document_approve == 0 ? ' required' : null}}/>
                </div>
                @endif
                @if ($user->corporate_account_note)
                <div class="form-group">
                    <div class="alert alert-outline-warning">{{$user->corporate_account_note}}</div>
                </div>
                @endif
                <div class="form-group">
                    @if (!is_null(auth()->user()->tax_document) || !is_null(auth()->user()->record_document) || !is_null(auth()->user()->identity_document))
                    <button type="submit" class="btn btn-primary btn-lg">GÜNCELLE</button>
                    @else
                    <button type="submit" class="btn btn-primary btn-lg">ONAYA GÖNDER</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
