@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12  order-1 order-xl-0">
                    <h2 class=" lh-sm">Projeler</h2>

                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            <div class="card-body p-0">
                                <div class="p-4 code-to-copy">
                                    <div id="tableExample"
                                        data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                                        <div class="table-responsive mx-n1 px-1">
                                            <table class="table table-sm border-top border-200 fs--1 mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Resim</th>
                                                        <th>Başlık</th>
                                                        <th>Eklenen Marka</th>
                                                        <th>Emlak Sayısı</th>
                                                        <th>Emlak Tipi</th>
                                                        <th>Şehir</th>
                                                        <th>İlçe</th>
                                                        <th>Statü</th>
                                                        <th>İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($projects as $key => $project)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>
                                                                @php
                                                                    $imagePath = str_replace('public/', 'storage/', $project->image);
                                                                @endphp
                                                                <img src="{{ asset($imagePath) }}" alt="Resim"
                                                                    style="width:100px">
                                                            </td>
                                                            <td>{{ $project->project_title }}</td>
                                                            <td>{{ $project->user->name }}</td>
                                                            <td>{{ $project->room_count }}</td>
                                                            <td>{{ $project->housingType->title }}</td>
                                                            <td>{{ $project->city->title }}</td>
                                                            <td>{{ isset($project->county->ilce_title) ? $project->county->ilce_title  : '' }}</td>
                                                            <td>
                                                                @if ($project->status == 1)
                                                                <span class="badge badge-phoenix badge-phoenix-success">Aktif</span>
                                                                @elseif($project->status == 2)
                                                                    <span class="badge badge-phoenix badge-phoenix-warning">Onay Bekliyor</span>
                                                                @elseif($project->status == 3)
                                                                    <span class="badge badge-phoenix badge-phoenix-danger">
                                                                        Reddedildi</span>
                                                                @else
                                                                    <span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('admin.projects.detail', $project->id) }}"
                                                                    class="badge badge-phoenix badge-phoenix-primary"><i
                                                                        class="fa fa-eye"></i></a>
                                                                <a href="{{ route('admin.projects.logs', $project->id) }}"
                                                                    class="badge badge-phoenix badge-phoenix-info">Log</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
