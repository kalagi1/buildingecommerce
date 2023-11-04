@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="row">
            <div class="card shadow-none border border-300  p-0" data-component-card="data-component-card">
                <div class="card-header border-bottom border-300 bg-soft">
                    <div class="row g-3 justify-content-between align-items-center">
                        <div class="col-12 col-md">
                            <h4 class="text-900 mb-0" data-anchor="data-anchor" id="soft-buttons">Yeni Abonelik Planı Oluştur</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
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
                        <form action="{{ route('admin.subscriptionPlans.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="name">Plan Adı</label>
                                <input class="form-control" id="name" name="name" type="text" placeholder="Plan Adı" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="price">Fiyat</label>
                                <input class="form-control" id="price" name="price" type="number" placeholder="Fiyat" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="project_limit">Proje Limiti</label>
                                <input class="form-control" id="project_limit" name="project_limit" type="number" placeholder="Proje Limiti" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="user_limit">Alt Kullanıcı Limiti</label>
                                <input class="form-control" id="user_limit" name="user_limit" type="number" placeholder="Alt Kullanıcı Limiti" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="housing_limit">Konut Limiti</label>
                                <input class="form-control" id="housing_limit" name="housing_limit" type="number" placeholder="Konut Limiti" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="plan_type">Plan Türü</label>
                                <select name="plan_type" id="plan_type" class="form-control">
                                    <option value="Bireysel">Bireysel</option>
                                    <option value="Emlakçı">Emlakçı</option>
                                    <option value="Banka">Banka</option>
                                    <option value="İnşaat">İnşaat</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Oluştur</button>
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
