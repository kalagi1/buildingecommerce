@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Emlak İlanları</h2>
        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="housingTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="pendingHousingTypes-tab" data-bs-toggle="tab"
                        href="#pendingHousingTypes">Onay Bekleyen İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="active-tab" data-bs-toggle="tab" href="#active">Aktif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="disabledHousingTypes-tab" data-bs-toggle="tab"
                        href="#disabledHousingTypes">Reddedilen İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#inactive">Pasif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="deletedHousings-tab" data-bs-toggle="tab" href="#deletedHousings">Silinen
                        İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="soldHousings-tab" data-bs-toggle="tab" href="#soldHousings">Satılan İlanlar</a>
                </li>
            </ul>
            <div class="tab-content px-4 pb-4">
                @foreach (['activeHousingTypes', 'pendingHousingTypes', 'disabledHousingTypes', 'inactiveHousingTypes', 'deletedHousings', 'soldHousingsTypes'] as $type)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $type }}">
                        @include('admin.housings.housing_table' . ($type == 'deletedHousings' ? '_delete' : ''), [
                            'tableId' => 'bulk-select-body-' . $type,
                            'housingTypes' => $$type,
                        ])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const housingData = {
            activeHousingTypes: @json($activeHousingTypes),
            disabledHousingTypes: @json($disabledHousingTypes),
            pendingHousingTypes: @json($pendingHousingTypes),
            deletedHousings: @json($deletedHousings),
            inactiveHousingTypes: @json($inactiveHousingTypes),
            soldHousingsTypes: @json($soldHousingsTypes),
        };

        function createTable(tbodyId, housingTypes) {
            const tbody = document.getElementById(tbodyId);
            housingTypes.forEach(housingType => {
                const row = document.createElement('tr');

                const idCell = createCell('td', 'align-middle id', housingType.id + 2000000);
                const housingTitleCell = createCell('td', 'align-middle housing_title', `
                    ${housingType.title}
                    <br>
                    <span style='color:black;font-size:11px !important;font-weight:700'>
                        ${housingType.city.title} / ${housingType.district.ilce_title}${housingType.neighborhood ? ' / ' + housingType.neighborhood.mahalle_title : ''}
                    </span>
                `);
                const housingTypeCell = createCell('td', 'align-middle housing_type', housingType.housing_type.title);
                const housingConsultantCell = createCell('td', 'align-middle housing_type', getConsultantName(housingType));

                const statusCell = createCell('td', 'align-middle status', getStatusBadge(housingType.status));
                const createdAtCell = createCell('td', 'align-middle created_at', new Date(housingType.created_at).toLocaleDateString());
                const actionsCell = createCell('td', 'align-middle white-space-nowrap pe-0', getActionLinks(housingType));

                row.append(idCell, housingTitleCell, housingTypeCell, housingConsultantCell);

                if (!housingType.deleted_at) {
                    row.append(statusCell, createdAtCell, actionsCell);
                }

                if (tbodyId === 'bulk-select-body-soldHousingsTypes') {
                    const invoiceLinkCell = createCell('td', 'align-middle pe-0', getInvoiceLink(housingType.id));
                    const orderDetailCell = createCell('td', 'align-middle', getOrderDetailLink(housingType.id));
                    row.append(invoiceLinkCell, orderDetailCell);
                }

                const deleteReasonCell = createCell('td', 'align-middle delete_reason', housingType.deleteReason || '');
                row.append(deleteReasonCell);

                if (housingType.owner_id) {
                    const sharedListingTag = document.createElement('span');
                    sharedListingTag.className = 'badge badge-info ml-2';
                    sharedListingTag.textContent = 'Paylaşımlı İlan';
                    housingTitleCell.append(sharedListingTag);
                }

                tbody.append(row);
            });
        }

        function createCell(tag, className, innerHTML = '') {
            const cell = document.createElement(tag);
            cell.className = className;
            cell.innerHTML = innerHTML;
            return cell;
        }

        function getConsultantName(housingType) {
            if (housingType.consultant && housingType.consultant.name) {
                return housingType.consultant.name;
            }
            if (housingType.user && housingType.user.name) {
                return housingType.user.name;
            }
            return 'Mağaza Yöneticisi';
        }

        function getStatusBadge(status) {
            switch (status) {
                case 1:
                    return '<span class="badge badge-phoenix badge-phoenix-success">Aktif</span>';
                case 2:
                    return '<span class="badge badge-phoenix badge-phoenix-warning">Onay Bekleniyor</span>';
                case 3:
                    return '<span class="badge badge-phoenix badge-phoenix-danger">Yönetim Tarafından Reddedildi</span>';
                default:
                    return '<span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>';
            }
        }

        function getActionLinks(housingType) {
            return `
                <a class="badge badge-phoenix badge-phoenix-primary ml-2" href="{{ URL::to('/') }}/qR9zLp2xS6y/secured/housings/${housingType.id}/detail">Görüntüle</a>
                <a class="badge badge-phoenix badge-phoenix-warning ml-2 mr-2" href="{{ URL::to('/') }}/qR9zLp2xS6y/secured/housings/${housingType.id}/logs">Loglar</a>
            `;
        }

        function getInvoiceLink(id) {
            return `<a class="badge badge-phoenix badge-phoenix-success" href="{{ URL::to('/') }}/qR9zLp2xS6y/secured/sold/invoice_detail/${id}">Fatura Görüntüle</a>`;
        }

        function getOrderDetailLink(id) {
            return `<a class="badge badge-phoenix badge-phoenix-success" href="{{ URL::to('/') }}/qR9zLp2xS6y/secured/sold/order_detail/${id}">Sipariş Detay</a>`;
        }

        Object.keys(housingData).forEach(type => createTable(`bulk-select-body-${type}`, housingData[type]));

        new bootstrap.Tab(document.getElementById('pendingHousingTypes-tab')).show();
    </script>

    <style>
        .nav-tabs .nav-link {
            color: black !important;
        }
        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: red !important;
        }
        .ml-2 {
            margin-left: 20px;
        }
        .mr-2 {
            margin-right: 20px;
        }
    </style>
@endsection
