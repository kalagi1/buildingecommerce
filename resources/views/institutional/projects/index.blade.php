@extends('institutional.layouts.master')

@section('content')
    <div class="content">

        <div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":10,"pagination":true}'>
            @if (session()->has('success'))
                <div class="alert alert-success text-white">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white border-top border-bottom border-200 position-relative top-1">
                <div class="table-responsive scrollbar mx-n1 px-1">
                    <table class="table fs--1 mb-0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kapak Görseli</th>
                                <th>Proje Adı</th>
                                <th>Toplam Gayrimenkul Sayısı</th>
                                <th>Satış Adeti</th>
                                <th>Toplam Kazanç</th>
                                <th>Onaydaki Siparişler</th>
                                <th>Satışa Kapalı Adet</th>
                                <th>Satışa Açık Adet</th>
                                <th>İlan Düzenle</th>
                                <th>Sponsorlu</th>
                                <th>Yayında/Yayında Değil</th>
                                <th>İşlem Kayıtları & Proje Düzenle</th>
                            </tr>
                        </thead>
                        <tbody class="list" id="bulk-select-body"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="pop-up-v2 d-none">
        <div class="pop-back"></div>
        <div class="pop-content">
            <div class="pop-content-inner">
                <div class="back_icon d-none"><i class="fa fa-chevron-left"></i></div>
                <div class="close-pop-icon"><i class="fa fa-times"></i></div>
                <div class="step1">
                    <h2>Süresini Uzat</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="">Kaç ay uzatmak istiyorsun?</label>
                            <input type="text" class="form-control extend_time_month">
                        </div>
                        <div class="col-md-6 mt-3">
                            <button class="btn btn-success extend_time_button">Fiyatı Görüntüle</button>
                        </div>
                        <div class="col-md-12 price-list-on-extend d-none">
                            <table class="w-full price-table-extend-time mt-2">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label for="">Mevcut Bitiş Tarihi</label>
                                            <p>12-10-2022</p>
                                        </td>
                                        <td>
                                            <label for="">Yeni Bitiş Tarihi</label>
                                            <p>12-10-2022</p>
                                        </td>
                                        <td>
                                            <label for="">Fiyat</label>
                                            <p>1000₺</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-success step1_end_button mt-2">Süreyi Uzat</button>
                        </div>
                    </div>
                </div>
                <div class="step2 d-none">
                    <h2>Banka Hesaplarımız</h2>
                    <span>EFT/Havale yapacağınız bankayı seçiniz</span>
                    <div>
                        <div class="row">
                            @foreach ($bankAccounts as $bankAccount)
                                <div class="col-md-3 bank-account" bank_id="{{ $bankAccount->id }}">
                                    <img src="{{ URL::to('/') }}/{{ $bankAccount->image }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="step3 d-none">
                    <div class="back_icon"><i class="fa fa-chevron-left"></i></div>
                    <h2>Banka Bilgileri</h2>
                    <div class="item receipent_full_name">
                        <label for="">Alıcı Adı</label>
                        <span>Abdurrahman İslamoğlu</span>
                    </div>
                    <div class="item iban">
                        <label for="">Iban</label>
                        <span>TR24 2444 2444 2444 2444 2444 22</span>
                    </div>
                    <div class="item">
                        <label for="">Açıklamaya yazılması gereken metin</label>
                        <span class="bank_description_text"></span>
                    </div>
                    <div>
                        <button class="btn btn-success finish-extend-time">Ödemeyi yaptım ve bitiriyorum</button>
                    </div>
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var projects = @json($projects);
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

        console.log(projects);
        var tbody = document.getElementById("bulk-select-body");
        projects.forEach(function(project) {
            var row = document.createElement("tr");

            var checkboxCell = document.createElement("td");
            var checkboxDiv = document.createElement("div");
            checkboxDiv.className = "form-check mb-0 fs-0";
            var checkboxInput = document.createElement("input");
            checkboxInput.className = "form-check-input";
            checkboxInput.type = "checkbox";
            checkboxInput.setAttribute("data-bulk-select-row", JSON.stringify(project));
            checkboxDiv.appendChild(checkboxInput);
            checkboxCell.appendChild(checkboxDiv);

            var numberCell = document.createElement("td");
            numberCell.className = "align-middle title";
            numberCell.textContent = project.id;


            var slugCell = document.createElement("td");
            slugCell.className = "align-middle logo";
            slugCell.innerHTML = "<img style='width:100%;max-height:70px;' src='{{ URL::to('/') }}/" + project
                .image.replace("public", "storage") + "'  />";

                     var denemeCell = document.createElement("td");
                     denemeCell.className = "align-middle";
                     denemeCell.innerHTML = project.project_title;

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


       

            var totalAmountCell = document.createElement("td");
            totalAmountCell.className = "align-middle title";
            totalAmountCell.textContent = project.totalAmount + "₺";

            var totalCell = document.createElement("td");
            totalCell.className = "align-middle title";
            totalCell.textContent = project.room_count - project.cartOrders - project.offSale;

            var houseCount = document.createElement("td");
            houseCount.className = "align-middle status";
            houseCount.innerHTML = "<a href='{{ URL::to('/') }}/institutional/projects/" + project.id +
                "/housings' class='badge badge-phoenix badge-phoenix-success'>İlan Düzenle</a>";

            var standOutCell = document.createElement("td");
            standOutCell.className = "align-middle status";
            console.log(project);
            if(project.stand_out){
                if(project.stand_out.doping_price_payment_wait){
                    standOutCell.innerHTML = "<a href='#' class='badge badge-phoenix badge-phoenix-warning'>Ödeme Bekleniyor</a>";
                }else{
                    if(project.stand_out.doping_price_payment_cancel){
                        standOutCell.innerHTML = "<a href='{{ URL::to('/') }}/institutional/project_stand_out/" + project.id +
                        "' class='badge badge-phoenix badge-phoenix-info'>Öne Çıkar</a>";
                    }else{
                        standOutCell.innerHTML = "<a href='#' class='badge badge-phoenix badge-phoenix-success'>Sponsorlu</a>";
                    }
                }
            }else{
                standOutCell.innerHTML = "<a href='{{ URL::to('/') }}/institutional/project_stand_out/" + project.id +
                "' class='badge badge-phoenix badge-phoenix-info'>Öne Çıkar</a>";
            }

            var activeCell = document.createElement("td");
            activeCell.className = "align-middle status";
            activeCell.innerHTML = project.status == 1 ? 
            '<span class="badge badge-phoenix badge-phoenix-success">Yayında</span>' 
            : project.status == 2 ? 
            '<span class="badge badge-phoenix badge-phoenix-danger">Admin Onayı Bekliyor</span>' 
            : project.status == 3 ? 
            '<span class="badge badge-phoenix badge-phoenix-danger">Admin Tarafından Reddedildi</span>' 
            : project.status == 6 ?
            '<span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-clock"></i> Süresi Bitti</span><span class="badge badge-phoenix badge-phoenix-primary c-pointer extend-time" style="margin-left:5px;" project_id="' +
                project.id + '"><i class="fa fa-plus"></i> Süresini Uzat</span>' 
            : project.status == 7 ?
            '<span class="badge badge-phoenix badge-phoenix-warning"><i class="fa fa-clock"></i> Ödeme onayı bekliyor</span>' :
            '<span class="badge badge-phoenix badge-phoenix-danger">Yayında Değil</span>';

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

            actionsDiv.appendChild(viewLink);
            actionsDiv.appendChild(exportLink);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(numberCell);
            row.appendChild(slugCell);
            row.appendChild(denemeCell);
            row.appendChild(titleCCell);
            row.appendChild(titleCell);

            row.appendChild(totalAmountCell);

            row.appendChild(applyCell);
            row.appendChild(offSaleCell);
            row.appendChild(totalCell);

            row.appendChild(houseCount);
            row.appendChild(standOutCell);
            row.appendChild(activeCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });

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
    </style>
@endsection
