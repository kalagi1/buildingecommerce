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
        var activeHousingTypes = @json($activeHousingTypes);
        var inactiveHousingTypes = @json($inactiveHousingTypes);
        var pendingHousingTypes = @json($pendingHousingTypes);
        var disabledHousingTypes = @json($disabledHousingTypes);
        var soldHousingTypes = @json($soldHousingTypes);
        var isShareTypes = @json($isShareTypes);
        var user = @json($user);

        function createTable(tbody, housingTypes) {

            housingTypes.forEach(function(housingType) {
                var row = document.createElement("tr");

                var idCell = document.createElement("td");
                idCell.className = "align-middle id";
                idCell.textContent = housingType.id + 2000000;


                var housingTitleCell = document.createElement("td");
                housingTitleCell.className = "align-middle housing_title";
                housingTitleCell.innerHTML = housingType.housing_title

                var housingOwner = document.createElement("td");
                housingOwner.className = "align-middle housing_owner";





                var housingTypeCell = document.createElement("td");
                housingTypeCell.className = "align-middle housing_type";
                housingTypeCell.textContent = housingType.housing_type;

                var statusCell = document.createElement("td");
                statusCell.className = "align-middle status";
                statusCell.innerHTML = housingType.status == 1 ?
                    '<span class="badge badge-phoenix badge-phoenix-success">Aktif</span>' :
                    housingType.status == 2 ?
                    '<span class="badge badge-phoenix badge-phoenix-warning">Onay Bekleniyor</span>' :
                    housingType
                    .status == 3 ?
                    '<span class="badge badge-phoenix badge-phoenix-danger">Yönetim Tarafından Reddedildi</span>' :
                    '<span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>';

                var createdAtCell = document.createElement("td");
                createdAtCell.className = "align-middle created_at";
                createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();

                var actionsCell = document.createElement("td");
                actionsCell.className = "align-middle white-space-nowrap     pe-0";
                var actionsDiv = document.createElement("div");
                actionsDiv.className = "font-sans-serif btn-reveal-trigger position-static";

                var viewLinkCell = document.createElement("td");
                viewLinkCell.className = "align-middle";
                var viewLink = document.createElement("button");
                viewLink.className = "badge badge-phoenix badge-phoenix-warning btn-sm";
                viewLink.href = "{{ URL::to('/') }}/institutional/housings/" + housingType.id + '/logs';
                viewLink.textContent = "Loglar";
                viewLinkCell.appendChild(viewLink);


                if (tbody.id === 'bulk-select-body-isShareTypes' && user.type != 1) {

                    if (housingType.owner && housingType.user.id == housingType.owner.id) {
                        var ownerInfo = document.createElement("span");
                        ownerInfo.textContent = "Emlak Ofisi: " + housingType.user.name;
                        housingOwner.appendChild(ownerInfo);

                        var br = document.createElement("br");
                        housingOwner.appendChild(br);

                        if (housingType.user.mobile_phone != null) {
                            var mobilephoneInfo = document.createElement("span");
                            mobilephoneInfo.textContent = "Cep: " + housingType.user.mobile_phone;
                            housingOwner.appendChild(mobilephoneInfo);
                        }

                        var br = document.createElement("br");
                        housingOwner.appendChild(br);

                        if (housingType.user.phone != null) {
                            var phoneInfo = document.createElement("span");
                            phoneInfo.textContent = "İş: " + housingType.user.phone;
                            housingOwner.appendChild(phoneInfo);
                        }

                    } else {
                        var ownerInfo = document.createElement("span");
                        ownerInfo.textContent = housingType.owner.name;
                        housingOwner.appendChild(ownerInfo);

                        var br = document.createElement("br");
                        housingOwner.appendChild(br);

                        var phoneInfo = document.createElement("span");
                        phoneInfo.textContent = "Telefon: " + housingType.owner.mobile_phone;
                        housingOwner.appendChild(phoneInfo);


                    }


                }


                if (tbody.id == 'bulk-select-body-soldHousingTypes') {
                    var exportLinkCell = document.createElement("td");
                    exportLinkCell.className = "align-middle";
                    var exportLink = document.createElement("a");
                    exportLink.className = "badge badge-phoenix badge-phoenix-success btn-sm";
                    exportLink.href = "#";
                    exportLink.textContent = "-";
                    exportLinkCell.appendChild(exportLink);

                    var imageLinksCell = document.createElement("td");
                    imageLinksCell.className = "align-middle";
                    var imageLinks = document.createElement("a");
                    imageLinks.className = "badge badge-phoenix badge-phoenix-info btn-sm";
                    imageLinks.href = "#";
                    imageLinks.textContent = "-";
                    imageLinksCell.appendChild(imageLinks);

                    var invoiceLinkCell = document.createElement("td");
                    invoiceLinkCell.className = "align-middle";
                    var invoiceLink = document.createElement("a");
                    invoiceLink.className = "badge badge-phoenix badge-phoenix-success btn-sm";
                    invoiceLink.href = "{{ URL::to('/') }}/sold/invoice_detail/" + housingType.id;
                    invoiceLink.textContent = "Fatura Görüntüle";
                    invoiceLinkCell.appendChild(invoiceLink);

                    var orderDetailCell = document.createElement("td");
                    orderDetailCell.className = "align-middle";
                    var orderDetailLink = document.createElement("a");
                    orderDetailLink.className = "badge badge-phoenix badge-phoenix-success btn-sm";
                    orderDetailLink.href = "{{ URL::to('/') }}/sold/order_detail/" + housingType.id;
                    orderDetailLink.textContent = "Sipariş Detay";
                    orderDetailCell.appendChild(orderDetailLink);

                    var statusCell = document.createElement("td");
                    statusCell.className = "align-middle";
                    var statusLink = document.createElement("span");
                    statusLink.className = "badge badge-phoenix badge-phoenix-success btn-sm";

                    statusLink.textContent = "Onaylandı";
                    statusCell.appendChild(statusLink);

                } else {
                    var exportLinkCell = document.createElement("td");
                    exportLinkCell.className = "align-middle";
                    var exportLink = document.createElement("a");
                    exportLink.className = "badge badge-phoenix badge-phoenix-success btn-sm";
                    exportLink.href = "{{ URL::to('/') }}/institutional/edit_housing/" + housingType.id;
                    exportLink.textContent = "Düzenle";
                    exportLinkCell.appendChild(exportLink);

                    var imageLinksCell = document.createElement("td");
                    imageLinksCell.className = "align-middle";
                    var imageLinks = document.createElement("a");
                    imageLinks.className = "badge badge-phoenix badge-phoenix-info btn-sm";
                    imageLinks.href = "{{ URL::to('/') }}/institutional/edit_images/" + housingType.id;
                    imageLinks.textContent = "Resimler";
                    imageLinksCell.appendChild(imageLinks);

                    var deleteCell = document.createElement("td");
                    deleteCell.className = "align-middle";

                    var passiveButton = document.createElement("button");
                    passiveButton.className = "badge badge-phoenix badge-phoenix-danger btn-sm";
                    passiveButton.textContent = "Pasife Al";
                    passiveButton.addEventListener("click", function() {
                        // Kullanıcıdan onay al
                        var confirmDelete = confirm("Bu ilanı pasife almak istediğinizden emin misiniz?");
                        if (confirmDelete) {
                            var csrfToken = "{{ csrf_token() }}";
                            // Laravel route ismi
                            var routeName =
                                "{{ route('institutional.housings.passive', ['id' => ':id']) }}";
                            // API Endpoint'i oluştur
                            var apiUrl = routeName.replace(':id', housingType.id);

                            fetch(apiUrl, {
                                    method: "POST", // Silme işlemi için DELETE metodu
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": csrfToken, // CSRF token'ını ekleyin
                                    },
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error("Network response was not ok");
                                    }
                                    location.reload();
                                })
                                .then(data => {
                                    // Silme işlemi başarılı
                                    toastr.success("İlan başarıyla pasife alındı.");
                                    location.reload();
                                })
                                .catch(error => {
                                    console.error("There was a problem with the fetch operation:",
                                        error);
                                    // Silme işlemi başarısız
                                    toastr.error("İlan pasife alınırken bir hata oluştu.");
                                });
                        }
                    });

                    var activeButton = document.createElement("button");
                    activeButton.className = "badge badge-phoenix badge-phoenix-success btn-sm";
                    activeButton.textContent = "Aktife Al";
                    activeButton.addEventListener("click", function() {
                        // Kullanıcıdan onay al
                        var confirmDelete = confirm("Bu ilanı aktife almak istediğinizden emin misiniz?");
                        if (confirmDelete) {
                            var csrfToken = "{{ csrf_token() }}";
                            // Laravel route ismi
                            var routeName = "{{ route('institutional.housings.active', ['id' => ':id']) }}";
                            // API Endpoint'i oluştur
                            var apiUrl = routeName.replace(':id', housingType.id);

                            fetch(apiUrl, {
                                    method: "POST", // Silme işlemi için DELETE metodu
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": csrfToken, // CSRF token'ını ekleyin
                                    },
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error("Network response was not ok");
                                    }
                                    location.reload();
                                })
                                .then(data => {
                                    // Silme işlemi başarılı
                                    toastr.success("İlan başarıyla aktife alındı.");
                                    location.reload();
                                })
                                .catch(error => {
                                    console.error("There was a problem with the fetch operation:",
                                        error);
                                    // Silme işlemi başarısız
                                    toastr.error("İlan aktife alınırken bir hata oluştu.");
                                });
                        }
                    });

                    if (housingType.status == 1) {
                        deleteCell.appendChild(passiveButton);
                    } else if (housingType.status == 0) {
                        deleteCell.appendChild(activeButton);
                    }

                }

                if (tbody.id === 'bulk-select-body-soldHousingTypes') {
                    row.appendChild(idCell);
                    row.appendChild(housingTitleCell);
                    row.appendChild(housingTypeCell);
                    row.appendChild(statusCell);
                    row.appendChild(createdAtCell);
                    row.appendChild(viewLinkCell);
                    row.appendChild(exportLinkCell);
                    row.appendChild(imageLinksCell);
                    row.appendChild(statusCell);
                    row.appendChild(invoiceLinkCell).appendChild(orderDetailCell);

                } else if (tbody.id === 'bulk-select-body-isShareTypes') {

                    row.appendChild(idCell);
                    row.appendChild(housingTitleCell);
                    row.appendChild(housingOwner);
                    row.appendChild(housingTypeCell);
                    row.appendChild(statusCell);
                    row.appendChild(createdAtCell);
                    row.appendChild(viewLinkCell);
                    row.appendChild(exportLinkCell);
                    row.appendChild(imageLinksCell);
                    row.appendChild(actionsCell);
                    row.appendChild(deleteCell);

                } else {

                  
                    row.appendChild(idCell);
                    row.appendChild(housingTitleCell);
                    if (user.type == 1) {
                        
                        if (housingType.owner && housingType.user.id != housingType.owner.id) {
                            var ownerInfo = document.createElement("span");
                            ownerInfo.textContent = housingType.user.name;
                            housingOwner.appendChild(ownerInfo);

                            var br = document.createElement("br");
                            housingOwner.appendChild(br);

                            if (housingType.user.mobile_phone != null) {
                                var mobilephoneInfo = document.createElement("span");
                                mobilephoneInfo.textContent = "Cep: " + housingType.user.mobile_phone;
                                housingOwner.appendChild(mobilephoneInfo);
                            }

                            var br = document.createElement("br");
                            housingOwner.appendChild(br);

                            if (housingType.user.phone != null) {
                                var phoneInfo = document.createElement("span");
                                phoneInfo.textContent = "İş: " + housingType.user.phone;
                                housingOwner.appendChild(phoneInfo);
                            }

                        } else {
                            var ownerInfo = document.createElement("span");
                            ownerInfo.textContent = "Henüz Atanmadı";
                            housingOwner.appendChild(ownerInfo);


                        }

                        row.appendChild(housingOwner);

                    }

                    row.appendChild(housingTypeCell);
                    row.appendChild(statusCell);
                    row.appendChild(createdAtCell);
                    row.appendChild(viewLinkCell);
                    row.appendChild(exportLinkCell);
                    row.appendChild(imageLinksCell);
                    row.appendChild(actionsCell);
                    row.appendChild(deleteCell);

                }






                // row.appendChild(idCell);
                // row.appendChild(housingTitleCell);
                // row.appendChild(housingOwner);
                // row.appendChild(housingTypeCell);
                // row.appendChild(statusCell);
                // row.appendChild(createdAtCell);
                // row.appendChild(viewLinkCell);
                // row.appendChild(exportLinkCell);
                // row.appendChild(imageLinksCell);
                // row.appendChild(actionsCell);
                // if (tbody.id === 'bulk-select-body-soldHousingTypes') {
                // row.appendChild(invoiceLinkCell).appendChild(orderDetailCell);

                // }else{
                // row.appendChild(deleteCell);

                // }



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
        var housingTabs = new bootstrap.Tab(document.getElementById('active-tab'));
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
