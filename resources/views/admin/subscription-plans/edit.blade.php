@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300  p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Abonelik Planını Düzenle: {{ $subscriptionPlan->name }}</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 code-to-copy">
                        <form action="{{ route('admin.subscriptionPlans.update', $subscriptionPlan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="name">Plan Adı</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Plan Adı" value="{{ $subscriptionPlan->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="price">Fiyat</label>
                                <input class="form-control" id="price" name="price" type="number" placeholder="Fiyat" value="{{ $subscriptionPlan->price }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="project_limit">Proje Limiti</label>
                                <input class="form-control" id="project_limit" name="project_limit" type="number" placeholder="Proje Limiti" value="{{ $subscriptionPlan->project_limit }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="user_limit">Kullanıcı Limiti</label>
                                <input class="form-control" id="user_limit" name="user_limit" type="number" placeholder="Kullanıcı Limiti" value="{{ $subscriptionPlan->user_limit }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="housing_limit">Konut Limiti</label>
                                <input class="form-control" id="housing_limit" name="housing_limit" type="number" placeholder="Konut Limiti" value="{{ $subscriptionPlan->housing_limit }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="plan_type">Plan Türü</label>
                                <select name="plan_type" id="plan_type" class="form-control">
                                    <option value="Bireysel"{{ $subscriptionPlan->plan_type == 'Bireysel' ? ' selected' : null }}>Bireysel</option>
                                    <option value="Emlakçı"{{ $subscriptionPlan->plan_type == 'Emlakçı' ? ' selected' : null }}>Emlakçı</option>
                                    <option value="Banka"{{ $subscriptionPlan->plan_type == 'Banka' ? ' selected' : null }}>Banka</option>
                                    <option value="İnşaat"{{ $subscriptionPlan->plan_type == 'İnşaat' ? ' selected' : null }}>İnşaat</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Güncelle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- İhtiyaç duyduğunuz JavaScript dosyalarını burada ekleyebilirsiniz -->
    @stack('scripts')
@endsection
