@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Proje İlanları</h2>
        <div class="card shadow-none border border-300 my-4">
            <ul class="nav nav-tabs px-4 mt-3 mb-3" id="housingTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab" data-bs-toggle="tab" href="#active">Aktif İlanlar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="inactive-tab" data-bs-toggle="tab" href="#inactive">Pasif İlanlar</a>
                </li>
            </ul>
            <div class="tab-content px-4 pb-4">
                <div class="tab-pane fade show active" id="active">
                    @include('institutional.projects.project_table', [
                        'tableId' => 'bulk-select-body-active',
                        'projectTypes' => $activeProjects,
                    ])
                </div>
                <div class="tab-pane fade" id="inactive">
                    @include('institutional.projects.project_table', [
                        'tableId' => 'bulk-select-body-inactive',
                        'projectTypes' => $inactiveProjects,
                    ])
                </div>
            </div>
        </div>

    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .ml-3 {
            margin-left: 20px
        }

        .badge-success {
            background-color: green
        }

        .badge-danger {
            background-color: red
        }

        .badge-info {
            background-color: #e54242
        }

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

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var activeProjects = @json($activeProjects);
        var inactiveProjects = @json($inactiveProjects);
        var selectedProjectId = 0;
        var selectedBankId = 0;
        var selectedMonthValue = 0;
        var selectedProjectName = "";
        const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım",
            "Aralık"
        ]
        @if (request('update_item'))
            $.toast({
                heading: 'Başarılı',
                text: 'Başarıyla projeyi güncellediniz',
                position: 'top-right',
                stack: false
            })
        @endif

        function createTable(tbody, projectTypes) {
            projectTypes.forEach(function(project) {
                var row = document.createElement("tr");
                var numberCell = document.createElement("td");
                numberCell.className = "align-middle title";
                numberCell.textContent = project.id + 1000000;

                var denemeCell = document.createElement("td");
                denemeCell.className = "align-middle";
                denemeCell.innerHTML = project.project_title +
                    "<br><span style='color:black;font-size:11px !important;font-weight:700'>" + project.city
                    .title + " / " +
                    project.county.ilce_title + (project.neighbourhood ? " / " + project.neighbourhood
                        .mahalle_title : "") +
                    "</span>";


                var titleCCell = document.createElement("td");
                titleCCell.className = "align-middle title";
                titleCCell.textContent = project.room_count;

                var titleCell = document.createElement("td");
                titleCell.className = "align-middle title";
                titleCell.textContent = project.cartOrders;

                var applyCell = document.createElement("td");
                applyCell.className = "align-middle title";
                applyCell.textContent = project.paymentPending;

                var offSaleCell = document.createElement("td");
                offSaleCell.className = "align-middle title";
                offSaleCell.textContent = project.offSale;

                var totalCell = document.createElement("td");
                totalCell.className = "align-middle title";
                totalCell.textContent = project.room_count - project.cartOrders - project.offSale;

                var houseCount = document.createElement("td");
                houseCount.className = "align-middle status";
                houseCount.innerHTML = "<a href='{{ URL::to('/') }}/institutional/projects/" + project.id +
                    "/housings' class='badge badge-phoenix badge-phoenix-success'>İlanları Düzenle</a>";

                // var standOutCell = document.createElement("td");
                // standOutCell.className = "align-middle status";
                // console.log(project);
                // if (project.stand_out) {
                //     if (project.stand_out.doping_price_payment_wait) {
                //         standOutCell.innerHTML =
                //             "<a href='#' class='badge badge-phoenix badge-phoenix-warning'>Ödeme Bekleniyor</a>";
                //     } else {
                //         if (project.stand_out.doping_price_payment_cancel) {
                //             standOutCell.innerHTML = "<a href='{{ URL::to('/') }}/institutional/project_stand_out/" +
                //                 project.id +
                //                 "' class='badge badge-phoenix badge-phoenix-info'>Öne Çıkar</a>";
                //         } else {
                //             standOutCell.innerHTML =
                //                 "<a href='#' class='badge badge-phoenix badge-phoenix-success'>Sponsorlu</a>";
                //         }
                //     }
                // } else {
                //     standOutCell.innerHTML = "<a href='{{ URL::to('/') }}/institutional/project_stand_out/" + project
                //         .id +
                //         "' class='badge badge-phoenix badge-phoenix-info'>Öne Çıkar</a>";
                // }

                var activeCell = document.createElement("td");
                activeCell.className = "align-middle status";
                activeCell.innerHTML = project.status == 1 ?
                    '<span class="text-success">Yayında</span>' :
                    project.status == 2 ?
                    '<span class="text-danger">Admin Onayı Bekliyor</span>' :
                    project.status == 3 ?
                    '<span class="text-danger">Admin Tarafından Reddedildi</span>' :
                    project.status == 7 ?
                    '<span class="text-warning"><i class="fa fa-clock"></i> Ödeme onayı bekliyor</span>' :
                    '<span class="text-danger">Yayında Değil</span>';

                var actionsCell = document.createElement("td");
                actionsCell.className = "align-middle white-space-nowrap pe-0";
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

                var dropdownMenu = document.createElement("div");
                dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
                var viewLink = document.createElement("a");
                viewLink.className = "badge badge-phoenix badge-phoenix-warning";
                viewLink.href = "{{ URL::to('/') }}/institutional/projects/" + project.id + '/logs';
                viewLink.textContent = "İşlem Kayıtları";
                var exportLink = document.createElement("a");
                exportLink.className = "badge badge-phoenix badge-phoenix-success ml-3";
                exportLink.href = "{{ URL::to('/') }}/institutional/edit_project_v2/" + project.slug;
                exportLink.textContent = "Proje Düzenle";
                var divider = document.createElement("div");
                divider.className = "dropdown-divider";

                var deleteCell = document.createElement("td");
                deleteCell.className = "align-middle";
                var deleteButton = document.createElement("button");
                deleteButton.className = "badge badge-phoenix badge-phoenix-danger btn-sm";
                deleteButton.textContent = "Sil";
                deleteButton.addEventListener("click", function() {
                    // Kullanıcıdan onay al
                    var confirmDelete = confirm("Bu projeyi silmek istediğinizden emin misiniz?");
                    if (confirmDelete) {
                        var csrfToken = "{{ csrf_token() }}";
                        // Laravel route ismi
                        var routeName = "{{ route('institutional.projects.destroy', ['id' => ':id']) }}";
                        // API Endpoint'i oluştur
                        var apiUrl = routeName.replace(':id', project.id);

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
                                toastr.success("Proje başarıyla silindi.");
                                location.reload();
                            })
                            .catch(error => {
                                console.error("There was a problem with the fetch operation:", error);
                                // Silme işlemi başarısız
                                toastr.error("Proje silinirken bir hata oluştu.");
                            });
                    }
                });

                deleteCell.appendChild(deleteButton);


                actionsDiv.appendChild(viewLink);
                actionsDiv.appendChild(exportLink);
                actionsCell.appendChild(actionsDiv);

                row.appendChild(numberCell);
                row.appendChild(denemeCell);
                row.appendChild(titleCCell);
                row.appendChild(titleCell);

                row.appendChild(applyCell);
                row.appendChild(offSaleCell);
                row.appendChild(totalCell);
                row.appendChild(activeCell);

                row.appendChild(houseCount);
                // row.appendChild(standOutCell);
                row.appendChild(actionsCell);
                row.appendChild(deleteCell);

                tbody.appendChild(row);
            });
        };
        createTable(document.getElementById("bulk-select-body-active"), activeProjects);
        createTable(document.getElementById("bulk-select-body-inactive"), inactiveProjects);

        var housingTabs = new bootstrap.Tab(document.getElementById('active-tab'));
        housingTabs.show();

        $('.extend-time').click(function() {
            $('.pop-up-v2').removeClass('d-none')
            selectedProjectId = $(this).attr('project_id');
        })

        $('.close-pop-icon').click(function() {
            $('.pop-up-v2').addClass('d-none')
        })

        $('.extend_time_button').click(function() {
            var monthValue = $('.extend_time_month').val();
            selectedMonthValue = monthValue;
            $.ajax({
                url: '{{ route('institutional.get.single.price') }}',
                type: 'get',
                data: {
                    month: monthValue,
                    selectedProjectId: selectedProjectId,
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    var currentEndDate = new Date(response.project.end_date);
                    var newEndDate = new Date(response.newDate);
                    selectedProjectName = response.project.project_title;
                    var html = '';
                    html = '<tr>' +
                        '<td>' +
                        '<label for="">Mevcut Bitiş Tarihi</label>' +
                        '<p>' + (months[currentEndDate.getMonth()]) + ' ' + currentEndDate.getDay() +
                        ', ' + currentEndDate.getFullYear() + '</p>' +
                        '</td>' +
                        '<td>' +
                        '<label for="">Yeni Bitiş Tarihi</label>' +
                        '<p>' + (months[newEndDate.getMonth()]) + ' ' + newEndDate.getDay() + ', ' +
                        newEndDate.getFullYear() + '</p>' +
                        '</td>' +
                        '<td>' +
                        '<label for="">Fiyat</label>' +
                        '<p>' + response.singlePrice.extend_price + '₺</p>' +
                        '</td>' +
                        '</tr>';
                    $('.price-table-extend-time tbody').html(html)
                    $('.price-list-on-extend').removeClass('d-none')
                },
                error: function(xhr) {
                    // Hata durumunda yapılacak işlemler burada
                    swal('Hata!', 'Proje silinirken bir hata oluştu.', 'error');
                }
            });
        })

        $('body').on('click', '.dropdown-item.text-danger', function(e) {
            e.preventDefault(); // Sayfa yenilemeyi engellemek için
            var projectId = $(this).data('project-id');
            var thisx = $(this);
            // Silme işlemi için bir onay kutusu (Swal) göster
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu markayı silmek istediğinizden emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'İptal',
                buttons: ['İptal', 'Sil'],
                dangerMode: true,
            }).then(function(willDelete) {
                // Silme işlemi onaylandıysa
                if (willDelete.isConfirmed) {
                    // Silme işlemi için Ajax isteği gönder
                    $.ajax({
                        url: '{{ route('institutional.projects.destroy', ':projectId') }}'.replace(
                            ':projectId', projectId),
                        type: 'post',
                        data: {
                            _method: "DELETE",
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            // Başarılı silme işlemi sonrası yapılacak işlemler burada
                            // Örneğin, kullanıcıyı tablodan kaldırabilirsiniz
                            thisx.closest('tr').remove();
                            // Silme başarılı mesajı göster
                            Swal.fire('Başarılı!', 'Proje başarıyla silindi.', 'success');
                        },
                        error: function(xhr) {
                            // Hata durumunda yapılacak işlemler burada
                            swal('Hata!', 'Proje silinirken bir hata oluştu.', 'error');
                        }
                    });
                }
            });
        });

        $('.step1_end_button').click(function() {
            $('.step2').removeClass('d-none')
            $('.step1').addClass('d-none')
            $('.back_icon').removeClass('d-none')
        })

        $('.bank-account').click(function() {
            selectedBankId = $(this).attr('bank_id');
            $('.step2').addClass('d-none')
            $('.step3').removeClass('d-none')
            $.ajax({
                url: '{{ route('institutional.get.bank.account', ':id') }}'.replace(':id', selectedBankId),
                type: 'get',
                success: function(response) {
                    $('.receipent_full_name span').html(response.receipent_full_name)
                    $('.iban span').html(response.iban)
                    $('.bank_description_text').html(selectedProjectName + ' projesinin süresini ' +
                        selectedMonthValue + ' ay uzatma')
                },
                error: function(xhr) {
                    // Hata durumunda yapılacak işlemler burada
                    swal('Hata!', 'Proje silinirken bir hata oluştu.', 'error');
                }
            });
            $('.back_icon').removeClass('d-none')
        })

        $('.back_icon').click(function() {
            if ($('.step1').hasClass('d-none')) {
                if ($('.step2').hasClass('d-none')) {
                    if ($('.step3').hasClass('d-none')) {

                    } else {
                        $('.step3').addClass('d-none')
                        $('.step2').removeClass('d-none')
                        $('.back_icon').removeClass('d-none')
                    }
                } else {
                    $('.step2').addClass('d-none')
                    $('.step1').removeClass('d-none')
                    $('.back_icon').addClass('d-none')
                }
            } else {

            }
        })

        $('.finish-extend-time').click(function() {
            $.ajax({
                url: '{{ route('institutional.create.payment.end.temp') }}',
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    month: selectedMonthValue,
                    bank_id: selectedBankId,
                    project_id: selectedProjectId
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        window.location.href = "{{ route('institutional.projects.index') }}"
                    }
                },
                error: function(xhr) {
                    // Hata durumunda yapılacak işlemler burada
                    swal('Hata!', 'Proje silinirken bir hata oluştu.', 'error');
                }
            });
        })
    </script>
@endsection
