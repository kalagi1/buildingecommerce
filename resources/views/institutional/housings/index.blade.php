@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Emlak İlanları</h2>
        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="housingTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#active">Aktif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pendingHousingTypes-tab" data-bs-toggle="tab" href="#pendingHousingTypes">Onay
                        Bekleyen İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="disabledHousingTypes-tab" data-bs-toggle="tab"
                        href="#disabledHousingTypes">Reddedilen İlanlar</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#inactive">Pasif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="soldHousingTypes-tab" data-bs-toggle="tab" href="#soldHousingTypes">Satılan
                        İlanlar</a>
                </li>
                @if ($user && $user->type != 1)
                    <li class="nav-item">
                        <a class="nav-link" id="isShareTypes-tab" data-bs-toggle="tab" href="#isShareTypes">Bana Atanan
                            İlanlar</a>
                    </li>
                @endif


            </ul>

            <div class="tab-content px-4 pb-4">
                <div class="tab-pane fade show active" id="active">
                    <div class="table-responsive">
                        @include('institutional.housings.housing_table', [
                            'tableId' => 'bulk-select-body-active',
                            'housingTypes' => $activeHousingTypes,
                        ])
                    </div>
                </div>
                <div class="tab-pane fade" id="pendingHousingTypes">
                    <div class="table-responsive">
                        @include('institutional.housings.housing_table', [
                            'tableId' => 'bulk-select-body-pendingHousingTypes',
                            'housingTypes' => $pendingHousingTypes,
                        ])
                    </div>
                </div>
                <div class="tab-pane fade" id="disabledHousingTypes">
                    <div class="table-responsive">
                        @include('institutional.housings.housing_table', [
                            'tableId' => 'bulk-select-body-disabledHousingTypes',
                            'housingTypes' => $disabledHousingTypes,
                        ])
                    </div>
                </div>
                <div class="tab-pane fade" id="inactive">
                    <div class="table-responsive">
                        @include('institutional.housings.housing_table', [
                            'tableId' => 'bulk-select-body-inactive',
                            'housingTypes' => $inactiveHousingTypes,
                        ])
                    </div>
                </div>
                <div class="tab-pane fade" id="soldHousingTypes">
                    <div class="table-responsive">
                        @include('institutional.housings.housing_table', [
                            'tableId' => 'bulk-select-body-soldHousingTypes',
                            'housingTypes' => $soldHousingTypes,
                        ])
                    </div>
                </div>

                <div class="tab-pane fade" id="isShareTypes">
                    <div class="table-responsive">
                        @include('institutional.housings.housing_isShare_table', [
                            'tableId' => 'bulk-select-body-isShareTypes',
                            'housingTypes' => $isShareTypes,
                        ])
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        const activeHousingTypes = @json($activeHousingTypes);
        const inactiveHousingTypes = @json($inactiveHousingTypes);
        const pendingHousingTypes = @json($pendingHousingTypes);
        const disabledHousingTypes = @json($disabledHousingTypes);
        const soldHousingTypes = @json($soldHousingTypes);
        const isShareTypes = @json($isShareTypes);
        const user = @json($user);
    
        function createTable(tbody, housingTypes) {
            housingTypes.forEach(housingType => {
                const row = document.createElement("tr");
    
                const createCell = (className, content) => {
                    const cell = document.createElement("td");
                    cell.className = `align-middle ${className}`;
                    cell.innerHTML = content;
                    return cell;
                };
    
                const idCell = createCell("id", housingType.id + 2000000);
                const housingTitleCell = createCell("housing_title", housingType.housing_title);
                const housingTypeCell = createCell("housing_type", housingType.housing_type);
                const statusContent = housingType.status == 1 ? 
                    '<span class="badge badge-phoenix badge-phoenix-success">Aktif</span>' : 
                    housingType.status == 2 ? 
                    '<span class="badge badge-phoenix badge-phoenix-warning">Onay Bekleniyor</span>' : 
                    housingType.status == 3 ? 
                    '<span class="badge badge-phoenix badge-phoenix-danger">Yönetim Tarafından Reddedildi</span>' : 
                    '<span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>';
                const statusCell = createCell("status", statusContent);
                const createdAtCell = createCell("created_at", new Date(housingType.created_at).toLocaleDateString());
                const viewLinkCell = createCell("", `<button class="badge badge-phoenix badge-phoenix-warning btn-sm" href="{{ URL::to('/') }}/institutional/housings/${housingType.id}/logs">Loglar</button>`);
    
                const housingConsultant = user.type !== 1 ? createCell("housing_type", housingType.consultant?.name ?? "Yönetici Hesap") : null;
                
                if (tbody.id === 'bulk-select-body-isShareTypes' && user.type !== 1) {
                    const housingOwner = createCell("housing_owner", "");
                    if (housingType.owner && housingType.user.id == housingType.owner.id) {
                        housingOwner.innerHTML = `
                            <span>Emlak Ofisi: ${housingType.user.name}</span><br>
                            ${housingType.user.mobile_phone ? `<span>Cep: ${housingType.user.mobile_phone}</span><br>` : ""}
                            ${housingType.user.phone ? `<span>İş: ${housingType.user.phone}</span><br>` : ""}
                        `;
                    } else {
                        housingOwner.innerHTML = `
                            <span>${housingType.owner.name}</span><br>
                            <span>Telefon: ${housingType.owner.mobile_phone}</span>
                        `;
                    }
                    row.append(idCell, housingTitleCell, housingOwner, housingTypeCell, housingConsultant, statusCell, createdAtCell, viewLinkCell);
                } else if (tbody.id === 'bulk-select-body-soldHousingTypes') {
                    const exportLinkCell = createCell("", `<a class="badge badge-phoenix badge-phoenix-success btn-sm" href="#">-</a>`);
                    const imageLinksCell = createCell("", `<a class="badge badge-phoenix badge-phoenix-info btn-sm" href="#">-</a>`);
                    const invoiceLinkCell = createCell("", `<a class="badge badge-phoenix badge-phoenix-success btn-sm" href="{{ URL::to('/') }}/sold/invoice_detail/${housingType.id}">Fatura Görüntüle</a>`);
                    const orderDetailCell = createCell("", `<a class="badge badge-phoenix badge-phoenix-success btn-sm" href="{{ URL::to('/') }}/sold/order_detail/${housingType.id}">Sipariş Detay</a>`);
                    const approvedStatusCell = createCell("", `<span class="badge badge-phoenix badge-phoenix-success btn-sm">Onaylandı</span>`);
                    row.append(idCell, housingTitleCell, housingTypeCell, housingConsultant, statusCell, createdAtCell, viewLinkCell, exportLinkCell, imageLinksCell, approvedStatusCell, invoiceLinkCell, orderDetailCell);
                } else {
                    const exportLinkCell = createCell("", `<a class="badge badge-phoenix badge-phoenix-success btn-sm" href="{{ URL::to('/') }}/hesabim/konut-duzenleme/${housingType.id}">Düzenle</a>`);
                    const imageLinksCell = createCell("", `<a class="badge badge-phoenix badge-phoenix-info btn-sm" href="{{ URL::to('/') }}/hesabim/gorsel-duzenleme/${housingType.id}">Resimler</a>`);
                    const deleteCell = createCell("", "");
                    row.append(idCell, housingTitleCell, housingTypeCell, housingConsultant, statusCell, createdAtCell, viewLinkCell, exportLinkCell, imageLinksCell, deleteCell);
                }
                
                tbody.appendChild(row);
            });
        }
    
        createTable(document.getElementById("bulk-select-body-active"), activeHousingTypes);
        createTable(document.getElementById("bulk-select-body-inactive"), inactiveHousingTypes);
        createTable(document.getElementById("bulk-select-body-pendingHousingTypes"), pendingHousingTypes);
        createTable(document.getElementById("bulk-select-body-disabledHousingTypes"), disabledHousingTypes);
        createTable(document.getElementById("bulk-select-body-soldHousingTypes"), soldHousingTypes);
        createTable(document.getElementById("bulk-select-body-isShareTypes"), isShareTypes);
    
        // Handle tab switching
        const housingTabs = new bootstrap.Tab(document.getElementById('active-tab'));
        housingTabs.show();
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
