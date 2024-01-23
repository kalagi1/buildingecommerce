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
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $key => $project)
                    <tr>
                        <td>{{ 1000000 + $project->id }}</td>
                        <td>
                            {{ $project->project_title }}<br>
                            <span style="color: black; font-size: 11px !important; font-weight: 700">
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
                    
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>