<div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
    <div class="table-responsive mx-n1 px-1">
        <table class="table table-sm border-top border-200 fs--1 mb-0">
            <thead>
                <tr>
                    <th>No.</th>
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
                        <td>{{ 1000000 + $project->id }}</td>
                        <td>
                            {{ $project->project_title }}<br>
                            <span style="color: black; font-size: 12px !important; font-weight: 700">
                                {{ $project->city->title }} / 
                                {{ $project->county->ilce_title ?? '' }} / 
                                {{ $project->neighbourhood->mahalle_title ?? '' }}
                            </span>
                        </td>
                        <td>{{ $project->user->name }} </td>
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
                                <span class="badge badge-phoenix badge-phoenix-danger">Reddedildi</span>
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