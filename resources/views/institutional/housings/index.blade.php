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

            </ul>
            {{dd($activeHousingTypes)}}
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
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        console.log("asd");
        var activeHousingTypes = @json($activeHousingTypes);
        var inactiveHousingTypes = @json($inactiveHousingTypes);
        var pendingHousingTypes = @json($pendingHousingTypes);
        var disabledHousingTypes = @json($disabledHousingTypes);


        function createTable(tbody, housingTypes) {
            housingTypes.forEach(function(housingType) {
                var row = document.createElement("tr");

                var idCell = document.createElement("td");
                idCell.className = "align-middle id";
                idCell.textContent = housingType.id + 2000000;
                console.log(housingType);

                var housingTitleCell = document.createElement("td");
                housingTitleCell.className = "align-middle housing_title";
                housingTitleCell.innerHTML = housingType.housing_title +
                    "<br><span style='color:black;font-size:11px !important;font-weight:700'>" + housingType.city
                    .title + " / " +
                    housingType.county.title + (housingType.neighborhood ? " / " + housingType.neighborhood
                        .mahalle_title : "") +
                    "</span>";

                var housingOwner = document.createElement("td");
                if (housingType.owner && housingType.owner.name) {
                    housingOwner.className = "align-middle housing_owner";
                    housingOwner.textContent =  housingType.owner.name ;
                } 

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
                var deleteButton = document.createElement("button");
                deleteButton.className = "badge badge-phoenix badge-phoenix-danger btn-sm mx-2";
                deleteButton.textContent = "Sil";
                // Silme işlemi butonuna tıklanınca
                // Silme işlemi butonuna tıklanınca
                // Silme işlemi butonuna tıklanınca
                deleteButton.addEventListener("click", function() {
                    // Silme işlemi için bir pop-up modal oluştur
                    var deleteModal = `
        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">İlanı Sil</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Bu ilanı silmek istediğinizden emin misiniz?</p>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="deleteReason1" name="deleteReason" value="EmlakSepette.com aracılığı ile sattım / kiraladım">
                            <label class="form-check-label" for="deleteReason1">EmlakSepette.com aracılığı ile sattım / kiraladım</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="deleteReason2" name="deleteReason" value="EmlakSepette.com harici kuruma sattım / kiraladım">
                            <label class="form-check-label" for="deleteReason2">EmlakSepette.com harici kuruma sattım / kiraladım</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" id="deleteReason3" name="deleteReason" value="Satmaktan / kiralamaktan vazgeçtim">
                            <label class="form-check-label" for="deleteReason3">Satmaktan / kiralamaktan vazgeçtim</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Sil</button>
                    </div>
                </div>
            </div>
        </div>
    `;

                    // Pop-up modalı sayfaya ekleyin
                    document.body.insertAdjacentHTML('beforeend', deleteModal);

                    // Pop-up modalı göster
                    $('#confirmDeleteModal').modal('show');

                    // Silme işlemini onaylayan butona tıklandığında
                    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
                        // Seçilen radio button'ı bul
                        var checkedRadio = document.querySelector(
                            'input[name="deleteReason"]:checked');

                        // Seçili radio button yoksa uyarı ver
                        if (!checkedRadio) {
                            alert("Lütfen silme nedenini seçin.");
                            return;
                        }

                        // Seçili radio button'ın değerini al
                        var deleteReason = checkedRadio.value;

                        // CSRF token ve API Endpoint'i al
                        var csrfToken = "{{ csrf_token() }}";
                        var routeName =
                            "{{ route('institutional.housings.destroy', ['id' => ':id']) }}";
                        var apiUrl = routeName.replace(':id', housingType.id);

                        // Silme işlemini gerçekleştir
                        fetch(apiUrl, {
                                method: "DELETE", // DELETE metodu kullan
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": csrfToken, // CSRF token'ı ekle
                                },
                                body: JSON.stringify({
                                    deleteReason: deleteReason
                                }) // Silme nedenini JSON olarak gönder
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error("Network response was not ok");
                                }
                                location.reload();
                            })
                            .then(data => {
                                // Silme işlemi başarılı
                                toastr.success("İlan başarıyla silindi.");
                                location.reload();
                            })
                            .catch(error => {
                                console.error("There was a problem with the fetch operation:",
                                    error);
                                // Silme işlemi başarısız
                                toastr.error("İlan silinirken bir hata oluştu.");
                            });
                    });
                });




                var passiveButton = document.createElement("button");
                passiveButton.className = "badge badge-phoenix badge-phoenix-danger btn-sm";
                passiveButton.textContent = "Pasife Al";
                passiveButton.addEventListener("click", function() {
                    // Kullanıcıdan onay al
                    var confirmDelete = confirm("Bu ilanı pasife almak istediğinizden emin misiniz?");
                    if (confirmDelete) {
                        var csrfToken = "{{ csrf_token() }}";
                        // Laravel route ismi
                        var routeName = "{{ route('institutional.housings.passive', ['id' => ':id']) }}";
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
                                console.error("There was a problem with the fetch operation:", error);
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
                                console.error("There was a problem with the fetch operation:", error);
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
                deleteCell.appendChild(deleteButton);

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
            


                tbody.appendChild(row);
            });
        }

        createTable(document.getElementById("bulk-select-body-active"), activeHousingTypes);
        createTable(document.getElementById("bulk-select-body-inactive"), inactiveHousingTypes);
        createTable(document.getElementById("bulk-select-body-pendingHousingTypes"), pendingHousingTypes);
        createTable(document.getElementById("bulk-select-body-disabledHousingTypes"), disabledHousingTypes);



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
