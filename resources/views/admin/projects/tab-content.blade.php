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
                    <th>Kapora Oranı</th>
                    <th>Emlak Kulüp Emlakçı Oranı</th>
                    <th>İlanları Düzenle</th>
                    <th>Yayın Durumu</th>
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
                            <form method="POST" action="{{ route('admin.projects.update', $project['project']->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-0">
                                    <input type="number" class="form-control w-70" id="deposit_rate" name="deposit_rate"
                                        value="{{ $project['project']->deposit_rate }}">
                                </div>

                                <button type="submit" class="update-button"
                                    style="color:red;font-weight:700;background:transparent;border:none;background-color:White">Güncelle</button>




                            </form>
                        </td>
                        <td>
                            <form method="POST"
                                action="{{ route('admin.projects.club-rate-update', $project['project']->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-0">
                                    <input type="number" class="form-control w-70" id="club_rate" name="club_rate"
                                        value="{{ $project['project']->club_rate }}">
                                </div>

                                <button type="submit" class="update-button"
                                    style="color:red;font-weight:700;background:transparent;border:none;background-color:White">Güncelle</button>




                            </form>
                        </td>

                        <td><a href='{{ URL::to('/') }}/qR9zLp2xS6y/secured/projects/{{ $project['project']->id }}/housings'
                                class='badge badge-phoenix badge-phoenix-success'>İlanları Düzenle</a></td>
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
                        {{-- <td>
                            <a href='{{ URL::to('/') }}/qR9zLp2xS6y/secured/projects/{{ $project['project']->id }}/orders'
                                class='badge badge-phoenix badge-phoenix-warning'>
                                Siparişleri Gör ({{ $project['orderCount'] }})
                            </a>
                        </td> --}}
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
