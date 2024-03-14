@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="row g-4">
            <div class="col-12 col-xl-12 order-1 order-xl-0">
                <div class="mb-9">
                    <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                        <div class="card-body p-0">
                            <div class="p-4 code-to-copy">
                                <div class="d-flex align-items-center justify-content-between my-3">
                                    <h2 class="mb-2 lh-sm">Kampanyalarım</h2>

                                    <div id="bulk-select-replace-element">
                                        <a class="btn btn-phoenix-success btn-sm"
                                            href="{{ route('institutional.offers.create') }}">
                                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                            <span class="ms-1">Yeni Kampanya Ekle</span>
                                        </a>
                                    </div>
                                </div>
                                <div id="tableExample"
                                    data-list='{"valueNames":["name","email","age"],"page":10,"pagination":true}'>
                                    @if (session()->has('success'))
                                        <div class="alert alert-success text-white text-white">
                                            {{ session()->get('success') }}
                                        </div>
                                    @endif
                                    <div class="table-responsive mx-n1 px-1">
                                        <table class="table table-sm border-top border-200 fs--1 mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>İlan Görseli</th>
                                                    <th>İlan Başlığı</th>
                                                    <th>İndirim Tutarı</th>
                                                    <th>Başlangıç Tarihi</th>
                                                    <th>Bitiş Tarihi</th>
                                                    <th>Kalan Gün</th>
                                                    <th colspan="2">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody class="list" id="bulk-select-body"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <style>
        .not-started {
            color: green !important;
            /* Başlamamış kampanyalar için yeşil renk */
        }

        .ending-soon {
            color: red !important;
            /* Bitecek olan kampanyalar için kırmızı renk */
        }
    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        var siteUrl = "{{ URL::to('/') }}/"; // Site URL'si

        var projects = @json($offers);

        var tbody = document.getElementById("bulk-select-body");
        var counter = 1;
        projects.forEach(function(project) {
            console.log(project);
            var row = document.createElement("tr");

            var noCell = document.createElement("td");
            noCell.className = "align-middle ps-3 title";
            noCell.textContent = counter;
            counter++;

            var projectType = project.type; // Projenin tipini al

            var imageCell = document.createElement("td"); // Görseli gösterecek hücre
            imageCell.className = "align-middle ps-3 title";
            imageCell.style.width = "100px"; // Genişliği 100 piksel olarak ayarla
            var image = document.createElement("img"); // Görsel öğesi oluştur
            image.className = "project-image w-full"; // CSS sınıfı ekle
            if (projectType === 'project') { // Eğer proje tipi 'project' ise
                image.src = siteUrl + project.project.image; // Proje görselini belirle
            } else if (projectType === 'housing') { // Eğer proje tipi 'housing' ise
                var jsonParse = JSON.parse(project.housing.housing_type_data);

                image.src = siteUrl + "housing_images/" + jsonParse.image; // Konut görselini belirle
            }
            imageCell.appendChild(image); // Görseli hücreye ekle

            var nameCell = document.createElement("td"); // Proje adını veya konut adını gösterecek hücre
            nameCell.className = "align-middle ps-3 title";

            if (projectType === 'project') { // Eğer proje tipi 'project' ise
                nameCell.textContent = project.project.project_title;
                if (project.project_housings) { // Eğer project_housings değeri dolu ise
                    var housingData = JSON.parse(project.project_housings); // JSON parse yap
                    var housingInfo = document.createElement("p");
                    housingInfo.textContent = "İndirim uygulanan konutlar: ";
                    nameCell.appendChild(housingInfo);
                    housingData.forEach(function(housing, index) {
                        var housingTitle = document.createElement("strong");
                        housingTitle.textContent = housing; // Başlık oluştur
                        housingInfo.appendChild(housingTitle); // Başlığı hücreye ekle
                        if (index !== housingData.length - 1) {
                            housingInfo.appendChild(document.createTextNode(', '));
                        }
                    });

                }
            } else if (projectType === 'housing') { // Eğer proje tipi 'housing' ise
                nameCell.textContent = project.housing.title; // Konut adını hücreye ekle
            }

            var aCell = document.createElement("td");
            aCell.className = "align-middle ps-3 title";
            aCell.textContent = numberWithCommas(project.discount_amount); // Fiyatı noktalı şekilde yazdır


            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            var sdCell = document.createElement("td");
            sdCell.className = "align-middle ps-3 title";
            sdCell.textContent = formatDate(project.start_date); // Başlangıç tarihini belirtilen formata dönüştür

            var edCell = document.createElement("td");
            edCell.className = "align-middle ps-3 title";
            edCell.textContent = formatDate(project.end_date); // Bitiş tarihini belirtilen formata dönüştür

            var remainingDaysCell = document.createElement("td");
            remainingDaysCell.className = "align-middle ps-3 title";
            remainingDaysCell.textContent = calculateRemainingDays(project.start_date, project
                .end_date); // Kalan günleri hesapla ve ekle
            if (remainingDaysCell.textContent.includes('Başlamadı')) { // Eğer kampanya başlamamışsa
                remainingDaysCell.classList.add('not-started'); // Yeşil renkte göster
            } else if (remainingDaysCell.textContent.includes('Bitimine')) { // Eğer kampanya bitecekse
                remainingDaysCell.classList.add('ending-soon'); // Kırmızı renkte göster
            }

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
            var dropdownMenu = document.createElement("div");
            dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
            var exportLink = document.createElement("a");
            exportLink.className = "btn btn-primary";
            exportLink.href = "{{ URL::to('/') }}/institutional/offers/" + project.id + '/edit';
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
            var removeLink = document.createElement("a");
            removeLink.className = "btn btn-dangerous text-danger";
            removeLink.href = "#!";
            removeLink.textContent = "Sil";
            removeLink.setAttribute("data-project-id", project.id);
            actionsDiv.appendChild(exportLink);
            actionsDiv.appendChild(removeLink);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(noCell);
            row.appendChild(imageCell); // Görsel hücreyi satıra ekle
            row.appendChild(nameCell); // Ad hücresini satıra ekle
            row.appendChild(aCell);
            row.appendChild(sdCell);
            row.appendChild(edCell);
            row.appendChild(remainingDaysCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });

        function formatDate(dateString) {
            var date = new Date(dateString);
            return date.toLocaleDateString('tr-TR'); // Tarih formatını belirt
        }

        function calculateRemainingDays(startDate, endDate) {
            var start = new Date(startDate);
            var end = new Date(endDate);
            var today = new Date();
            if (today < start) { // Kampanya henüz başlamadıysa
                var diff = Math.ceil((start - today) / (1000 * 60 * 60 * 24));
                return "Başlamadı - " + diff + " gün kaldı";
            } else { // Kampanya başladıysa
                var diff = Math.ceil((end - today) / (1000 * 60 * 60 * 24));
                if (diff > 0) {
                    return "Bitimine - " + diff + " gün kaldı";
                } else {
                    return "Sonlandı";
                }
            }
        }


        $('body').on('click', '.text-danger', function(e) {
            e.preventDefault();

            var projectId = $(this).data('project-id');
            var thisx = $(this);
            console.log(projectId);
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu kampanyayı silmek istediğinizden emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'İptal',
                buttons: ['İptal', 'Sil'],
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete.isConfirmed) {
                    $.ajax({
                        url: '{{ route('institutional.offers.delete', ':projectId') }}'.replace(
                            ':projectId', projectId),
                        type: 'post',
                        data: {
                            _method: "DELETE",
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            thisx.closest('tr').remove();
                            Swal.fire('Başarılı!', 'Kampanya başarıyla silindi.', 'success');
                        },
                        error: function(xhr) {
                            swal('Hata!', 'Kampanya silinirken bir hata oluştu.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
