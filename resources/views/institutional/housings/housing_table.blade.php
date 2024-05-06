<table class="table table-sm border-top border-200 fs--1 mb-0">
    <thead>
        <tr>
            <th>ID</th>
            <th>Başlık</th>
            @if (Auth::user()->type != 1)
                <th>İlan Sahibi</th>
            @else
                <th>Emlak Ofisi</th>
            @endif
            <th>Emlak Tipi</th>
            <th>Statü</th>
            <th>Oluşturulma Tarihi</th>
            <th>Loglar</th>
            <th>Düzenle</th>
            <th>{{ isset($tableId) && $tableId === 'bulk-select-body-soldHousingTypes' ? 'Sipariş Durumu' : 'Resimler' }}
            </th>
            <th colspan="2">İşlemler</th>

        </tr>
    </thead>
    <tbody class="list" id="{{ $tableId }}"></tbody>
</table>
