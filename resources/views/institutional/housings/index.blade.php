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
                    <a class="nav-link" id="pendingHousingTypes-tab" data-bs-toggle="tab" href="#pendingHousingTypes">Onay Bekleyen İlanlar</a>
                </li>
             
                <li class="nav-item">
                    <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#inactive">Pasif İlanlar</a>
                </li>
              
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
                <div class="tab-pane fade" id="inactive">
                    <div class="table-responsive">
                    @include('institutional.housings.housing_table', [
                        'tableId' => 'bulk-select-body-inactive',
                        'housingTypes' => $pendingHousingTypes,
                    ])
                    </div>
                </div>
                <div class="tab-pane fade" id="pendingHousingTypes">
                    <div class="table-responsive">
                    @include('institutional.housings.housing_table', [
                        'tableId' => 'bulk-select-body-pendingHousingTypes',
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
        var activeHousingTypes = @json($activeHousingTypes);
        var inactiveHousingTypes = @json($inactiveHousingTypes);
        var pendingHousingTypes = @json($pendingHousingTypes);



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

                var housingTypeCell = document.createElement("td");
                housingTypeCell.className = "align-middle housing_type";
                housingTypeCell.textContent = housingType.housing_type;

                var statusCell = document.createElement("td");
                statusCell.className = "align-middle status";
                statusCell.innerHTML = housingType.status == 1 ?
                    '<span class="badge badge-phoenix badge-phoenix-success">Aktif</span>' :
                    housingType.status == 2 ?
                    '<span class="badge badge-phoenix badge-phoenix-warning">Admin Onayı Bekliyor</span>' :
                    housingType
                    .status == 3 ?
                    '<span class="badge badge-phoenix badge-phoenix-danger">Admin Tarafından Reddedildi</span>' :
                    '<span class="badge badge-phoenix badge-phoenix-danger">Pasif</span>';

                var createdAtCell = document.createElement("td");
                createdAtCell.className = "align-middle created_at";
                createdAtCell.textContent = new Date(housingType.created_at).toLocaleDateString();

                var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap     pe-0";
            var actionsDiv = document.createElement("div");
            actionsDiv.className = "font-sans-serif btn-reveal-trigger position-static";
            var actionsButton = document.createElement("button");
            actionsButton.className =
                "btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2";
            actionsButton.type = "button";
            actionsButton.setAttribute("data-bs-toggle", "dropdown");
            actionsButton.setAttribute("data-bs-boundary", "window");
            actionsButton.setAttribute("aria-haspopup", "true");
            actionsButton.setAttribute("aria-expanded", "false");
            actionsButton.setAttribute("data-bs-reference", "parent");
            var actionsIcon = document.createElement("span");
            actionsIcon.className = "fas fa-ellipsis-h fs--2";
            actionsButton.appendChild(actionsIcon);
            actionsDiv.appendChild(actionsButton);
            var dropdownMenu = document.createElement("div");
            dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
            var viewLink = document.createElement("a");
            viewLink.className = "dropdown-item";
            viewLink.href = "{{ URL::to('/') }}/institutional/housings/" + housingType.id + '/logs';
            viewLink.textContent = "Loglar";
            var exportLink = document.createElement("a");
            exportLink.className = "dropdown-item";
            exportLink.href = "{{ URL::to('/') }}/institutional/edit_housing/" + housingType.id;
            exportLink.textContent = "Düzenle";
            var imageLinks = document.createElement("a");
            imageLinks.className = "dropdown-item";
            imageLinks.href = "{{ URL::to('/') }}/institutional/edit_images/" + housingType.id;
            imageLinks.textContent = "Resimler";
            dropdownMenu.appendChild(viewLink);
            dropdownMenu.appendChild(exportLink);
            dropdownMenu.appendChild(imageLinks);
            actionsDiv.appendChild(dropdownMenu);
            actionsCell.appendChild(actionsDiv);


                var deleteCell = document.createElement("td");
                deleteCell.className = "align-middle";
                var deleteButton = document.createElement("button");
                deleteButton.className = "badge badge-phoenix badge-phoenix-danger btn-sm";
                deleteButton.textContent = "Sil";
                deleteButton.addEventListener("click", function() {
                    // Kullanıcıdan onay al
                    var confirmDelete = confirm("Bu ianı silmek istediğinizden emin misiniz?");
                    if (confirmDelete) {
                        var csrfToken = "{{ csrf_token() }}";
                        // Laravel route ismi
                        var routeName = "{{ route('institutional.housings.destroy', ['id' => ':id']) }}";
                        // API Endpoint'i oluştur
                        var apiUrl = routeName.replace(':id', housingType.id);

                        fetch(apiUrl, {
                                method: "DELETE", // Silme işlemi için DELETE metodu
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
                                toastr.success("İlan başarıyla silindi.");
                                location.reload();
                            })
                            .catch(error => {
                                console.error("There was a problem with the fetch operation:", error);
                                // Silme işlemi başarısız
                                toastr.error("İlan silinirken bir hata oluştu.");
                            });
                    }
                });

                deleteCell.appendChild(deleteButton);

                row.appendChild(idCell);
                row.appendChild(housingTitleCell);
                row.appendChild(housingTypeCell);
                row.appendChild(statusCell);
                row.appendChild(createdAtCell);
                row.appendChild(actionsCell);
                row.appendChild(deleteCell);



                tbody.appendChild(row);
            });
        }

        createTable(document.getElementById("bulk-select-body-active"), activeHousingTypes);
        createTable(document.getElementById("bulk-select-body-inactive"), inactiveHousingTypes);
        createTable(document.getElementById("bulk-select-body-pendingHousingTypes"), pendingHousingTypes);



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
