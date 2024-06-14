<table class="table table-sm border-top border-200 fs--1 mb-0">
    <thead>
        <tr>
            <th style="width: 100px">ID</th>
            <th>Başlık</th>
            
            <th>Emlak Tipi</th>
            @if (Auth::user()->type != 1)
            <th>Danışman</th>
            @endif
            <th>Statü</th>
            <th>Oluşturulma Tarihi</th>
            <th>Loglar</th>
            <th>Düzenle</th>
            <th>Pazarlık Teklifleri</th>
            <th>{{ isset($tableId) && $tableId === 'bulk-select-body-soldHousingTypes' ? 'Sipariş Durumu' : 'Resimler' }}
            </th>

        </tr>
    </thead>
    <tbody class="list" id="{{ $tableId }}"></tbody>
</table>
