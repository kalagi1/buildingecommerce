<div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
    <div class="table-responsive mx-n1 px-1">
        <table class="table table-sm border-top border-200 fs--1 mb-0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Proje Adı</th>
                    <th>Mağaza Adı</th>
                    <th>Toplam İlan Sayısı</th>
                    <th>Emlak Tipi</th>
                    <th>Yayın Durumu</th>
                    <th>Siparişleri Gör</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $key => $project)
                    <tr>
                        <td>{{ 1000000 + $project['project']->id }}</td>
                        <td>
                            {{ $project['project']->project_title }}<br>
                            <span style="color: black; font-size: 11px !important; font-weight: 700">
                                {{ $project['project']->city->title }} /
                                {{ $project['project']->county->ilce_title ?? '' }} /
                                {{ $project['project']->neighbourhood->mahalle_title ?? '' }}
                            </span>
                        </td>
                        <td>{{ $project['project']->user->name }} </td>
                        <td>{{ $project['project']->room_count }}</td>
                        <td>{{ $project['project']->housingType->title }}</td>
                        <td>
                            @if ($project['project']->status == 1)
                                <span class="badge badge-phoenix badge-phoenix-success">Aktif</span>
                            @elseif($project['project']->status == 2)
                                <span class="badge badge-phoenix badge-phoenix-warning">Onay Bekliyor</span>
                            @elseif($project['project']->status == 3)
                                <span class="badge badge-phoenix badge-phoenix-danger">Reddedildi</span>
                            @else
                                <span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>
                            @endif
                        </td>
                        <td>
                            <a href='{{ URL::to('/') }}/admin/projects/{{ $project['project']->id }}/orders'
                                class='badge badge-phoenix badge-phoenix-warning'>
                                Siparişleri Gör ({{ $project['orderCount'] }})
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.projects.detail', $project['project']->id) }}"
                                class="badge badge-phoenix badge-phoenix-primary"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('admin.projects.logs', $project['project']->id) }}"
                                class="badge badge-phoenix badge-phoenix-info">Log</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
