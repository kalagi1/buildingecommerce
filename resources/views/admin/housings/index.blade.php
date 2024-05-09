
@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Emlak İlanları</h2>
        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="housingTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="pendingHousingTypes-tab" data-bs-toggle="tab" href="#pendingHousingTypes">Onay Bekleyen İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="active-tab" data-bs-toggle="tab" href="#active">Aktif İlanlar</a>
                </li>
             
                <li class="nav-item">
                    <a class="nav-link" id="disabledHousingTypes-tab" data-bs-toggle="tab" href="#disabledHousingTypes">Reddedilen İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#inactive">Pasif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="deletedHousings-tab" data-bs-toggle="tab" href="#deletedHousings">Silinen İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="soldHousings-tab" data-bs-toggle="tab" href="#soldHousings">Satınlan İlanlar</a>
                </li>
            </ul>
            <div class="tab-content px-4 pb-4">
                <div class="tab-pane fade " id="active">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-active', 'housingTypes' => $activeHousingTypes])
                </div>
                <div class="tab-pane fade show active" id="pendingHousingTypes">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-pendingHousingTypes', 'housingTypes' => $pendingHousingTypes])
                </div>
                <div class="tab-pane fade" id="disabledHousingTypes">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-disabledHousingTypes', 'housingTypes' => $disabledHousingTypes])
                </div>
                <div class="tab-pane fade" id="inactive">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-inactive', 'housingTypes' => $inactiveHousingTypes])
                </div>
                <div class="tab-pane fade" id="deletedHousings">
                    @include('admin.housings.housing_table_delete', ['tableId' => 'bulk-select-body-deletedHousings', 'housingTypes' => $deletedHousings])
                </div>
                <div class="tab-pane fade" id="soldHousings">
                    @include('admin.housings.housing_table', ['tableId' => 'bulk-select-body-soldHousingsTypes', 'housingTypes' => $soldHousingsTypes])
                </div>
            </div>
        </div>
      
    </div>
@endsection

@section('scripts')
    <script>
        var activeHousingTypes = @json($activeHousingTypes);
        var inactiveHousingTypes = @json($inactiveHousingTypes);
        var pendingHousingTypes = @json($pendingHousingTypes);
        var deletedHousings = @json($deletedHousings);
        var disabledHousingTypes = @json($disabledHousingTypes);
        var soldHousingsTypes = @json($soldHousingsTypes);

        function createTable(tbody, housingTypes) {
            housingTypes.forEach(function(housingType) {
            var row = document.createElement("tr");
            

            var idCell = document.createElement("td");
            idCell.className = "align-middle id";
            idCell.textContent = housingType.id + 2000000;

            var housingTitleCell = document.createElement("td");
            housingTitleCell.className = "align-middle housing_title";
            housingTitleCell.innerHTML = housingType.housing_title +
                    "<br><span style='color:black;font-size:11px !important;font-weight:700'>" + housingType.city
                    .title + " / " +
                    housingType.county.title + (housingType.neighborhood ? " / " + housingType.neighborhood
                        .mahalle_title : "") +
                    "</span>";

            var housingTypeCell = document.createElement("td");
            housingTypeCell.className = "align-middle housing_type";
            housingTypeCell.textContent = housingType.housing_type;

            var housingConsultant = document.createElement("td");
                housingConsultant.className = "align-middle housing_type";
                housingConsultant.textContent = housingType.consultant != null ? housingType.consultant.name : "Yönetici";


            var statusCell = document.createElement("td");
            statusCell.className = "align-middle status";
            statusCell.innerHTML = housingType.status == 1 ? '<span class="badge badge-phoenix badge-phoenix-success">Aktif</span>' :
                housingType.status == 2 ? '<span class="badge badge-phoenix badge-phoenix-warning">Onay Bekleniyor</span>' : housingType
                .status == 3 ? '<span class="badge badge-phoenix badge-phoenix-danger">Yönetim Tarafından Reddedildi</span>' :
                '<span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>';
                

            var createdAtCell = document.createElement("td");
            createdAtCell.className = "align-middle created_at";
            createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();

            var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap     pe-0";
            var exportLink = document.createElement("a");
            exportLink.className = "badge badge-phoenix badge-phoenix-primary ml-2";
            exportLink.href = "{{ URL::to('/') }}/qR9zLp2xS6y/secured/housings/" + housingType.id + '/detail';
            exportLink.textContent = "Görüntüle";
            var viewLink = document.createElement("a");
            viewLink.className = "badge badge-phoenix badge-phoenix-warning ml-2 mr-2";
            viewLink.href = "{{ URL::to('/') }}/qR9zLp2xS6y/secured/housings/" + housingType.id + '/logs';
            viewLink.textContent = "Loglar";

                        
            actionsCell.appendChild(exportLink);
            actionsCell.appendChild(viewLink);

            if (tbody.id === "bulk-select-body-soldHousingsTypes") {

                var invoiceLinkCell = document.createElement("td");
                    invoiceLinkCell.className = "align-middle pe-0";
                    var invoiceLink = document.createElement("a");
                    invoiceLink.className = "badge badge-phoenix badge-phoenix-success";
                    invoiceLink.href = "{{ URL::to('/') }}/qR9zLp2xS6y/secured/sold/invoice_detail/" + housingType.id;
                    invoiceLink.textContent = "Fatura Görüntüle";
                    invoiceLinkCell.appendChild(invoiceLink);
        

                    var orderDetailCell = document.createElement("td");
                    orderDetailCell.className = "align-middle";
                    var orderDetailLink = document.createElement("a");
                    orderDetailLink.className = "badge badge-phoenix badge-phoenix-success";
                    orderDetailLink.href =  "{{ URL::to('/') }}/qR9zLp2xS6y/secured/sold/order_detail/" + housingType.id;
                    orderDetailLink.textContent = "Sipariş Detay";
                    orderDetailCell.appendChild(orderDetailLink);

                       // Daha önce oluşturulan "actionsCell" hücresine linkleri ekle
                    actionsCell.appendChild(invoiceLinkCell);
                    actionsCell.appendChild(orderDetailCell);
            }

            row.appendChild(idCell);
            row.appendChild(housingTitleCell);
            row.appendChild(housingTypeCell);
            row.appendChild(housingConsultant);

            if (housingType.deleted_at == null) {
                row.appendChild(statusCell);

            }
            row.appendChild(createdAtCell);
            
        
            if (housingType.deleted_at == null) {
                row.appendChild(actionsCell);

            }
            var deleteReasonCell = document.createElement("td");
            deleteReasonCell.className = "align-middle delete_reason";
            deleteReasonCell.textContent = housingType.deleteReason ? housingType.deleteReason : null;
            row.appendChild(deleteReasonCell);
            
            tbody.appendChild(row);
        });
        }

        createTable(document.getElementById("bulk-select-body-active"), activeHousingTypes);
        createTable(document.getElementById("bulk-select-body-inactive"), inactiveHousingTypes);
        createTable(document.getElementById("bulk-select-body-deletedHousings"), deletedHousings);
        createTable(document.getElementById("bulk-select-body-pendingHousingTypes"), pendingHousingTypes);
        createTable(document.getElementById("bulk-select-body-disabledHousingTypes"), disabledHousingTypes);
        createTable(document.getElementById("bulk-select-body-soldHousingsTypes"), soldHousingsTypes);


        // Handle tab switching
        var housingTabs = new bootstrap.Tab(document.getElementById('pendingHousingTypes-tab'));
        housingTabs.show();
    </script>

    <!-- Your existing styles -->
    <style>
        .nav-tabs .nav-link{
            color:black !important;
        }
        .nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link{
            color:red !important;
        }
        .ml-2 {
            margin-left: 20px;
        }

        .mr-2 {
            margin-right: 20px;
        }
    </style>
@endsection
