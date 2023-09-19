@extends('institutional.layouts.master')

@section('content')

<div class="content">
    <h2 class="mb-2 lh-sm">{{ucfirst($project->project_title)}} adlı projeyi öne çıkar</h2>
    <div class="form-area card p-5">
        <div class="row">
            <div class="col-md-4">
                <label for="">Projenizi seçiniz</label>
                <select name="" class="form-control project" id="">
                    <option value="">Proje 1</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="">Öne Çıkarım Başlangıç Tarihi</label>
                <input type="date" class="form-control start_date" >
            </div>
            <div class="col-md-4">
                <label for="">Öne Çıkarım Bitiş Tarihi</label>
                <input type="date" class="form-control end_date" >
            </div>
            <div class="col-md-12">
                <button class="btn btn-success mt-4 list-pricing">Fiyatları Listele</button>
            </div>
        </div>
    </div>
    <div class="mt-4">
      <div class="row g-4">
        <div class="col-12 col-xl-12 order-1 order-xl-0">
          <div class="mb-9">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
              <div class="card-body p-0">
                <div class="p-4 code-to-copy">
                  <div class="d-flex align-items-center justify-content-end my-3">
                    <div id="bulk-select-replace-element">
                        <a class="btn btn-phoenix-success btn-sm" href="{{route('institutional.brands.create')}}">
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span class="ms-1">Yeni Proje Ekle</span>
                        </a>
                    </div>
                    <div class="d-none ms-3" id="bulk-select-actions">
                      <div class="d-flex"><select class="form-select form-select-sm" aria-label="Bulk actions">
                          <option selected="selected">Bulk actions</option>
                          <option value="Delete">Delete</option>
                          <option value="Archive">Archive</option>
                        </select><button class="btn btn-phoenix-danger btn-sm ms-2" type="button">Apply</button></div>
                    </div>
                  </div>
                  <div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":5,"pagination":true}'>
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="table-responsive mx-n1 px-1">
                      <table class="table table-sm border-top border-200 fs--1 mb-0">
                        <thead>
                          <tr>
                            <th class="white-space-nowrap fs--1 align-middle ps-0" style="max-width:20px; width:18px;">
                              <div class="form-check mb-0 fs-0"><input class="form-check-input" id="bulk-select-example" type="checkbox" data-bulk-select='{"body":"bulk-select-body","actions":"bulk-select-actions","replacedElement":"bulk-select-replace-element"}' /></div>
                            </th>
                            <th>Proje Adı</th>
                            <th>Sıra</th>
                            <th>Fiyat</th>
                            <th>Statü</th>
                            <th>İşlemler</th>
                          </tr>
                        </thead>
                        <tbody class="list" id="bulk-select-body"></tbody>  
                      </table>
                    </div>
                    <div class="d-flex flex-between-center pt-3 mb-3">
                      <div class="pagination d-none"></div>
                      <p class="mb-0 fs--1">
                        <span class="d-none d-sm-inline-block" data-list-info="data-list-info"></span>
                        <span class="d-none d-sm-inline-block"> &mdash; </span>
                        <a class="fw-semi-bold" href="#!" data-list-view="*">
                          View all
                          <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                        </a><a class="fw-semi-bold d-none" href="#!" data-list-view="less">
                          View Less
                          <span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span>
                        </a>
                      </p>
                      <div class="d-flex">
                        <button class="btn btn-sm btn-primary" type="button" data-list-pagination="prev"><span>Previous</span></button>
                        <button class="btn btn-sm btn-primary px-4 ms-2" type="button" data-list-pagination="next"><span>Next</span></button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
      <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <footer class="footer position-absolute">
      <div class="row g-0 justify-content-between align-items-center h-100">
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 mt-2 mt-sm-0 text-900">Thank you for creating with Phoenix<span class="d-none d-sm-inline-block"></span><span class="d-none d-sm-inline-block mx-1">|</span><br class="d-sm-none" />2023 &copy;<a class="mx-1" href="https://themewagon.com/">Themewagon</a></p>
        </div>
        <div class="col-12 col-sm-auto text-center">
          <p class="mb-0 text-600">v1.13.0</p>
        </div>
      </div>
    </footer>
  </div>

  @endsection

  @section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  @endsection

  @section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        var projects = [];

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

            var titleCell = document.createElement("td");
            titleCell.className = "align-middle ps-3 title";
            titleCell.textContent = project.project_title;

            var slugCell = document.createElement("td");
            slugCell.className = "align-middle logo";
            slugCell.innerHTML =  "<img style='max-width:100px;max-height:50px;' src='{{ URL::to('/') }}/"+project.image.replace("public", "storage")+"'  />";


            var standOutCell = document.createElement("td");
            standOutCell.className = "align-middle status";
            standOutCell.innerHTML =  "<a href='{{URL::to('/')}}/institutional/project_stand_out/"+project.id+"' class='btn btn-info'>Öne Çıkar</a>";

            var activeCell = document.createElement("td");
            activeCell.className = "align-middle status";
            activeCell.innerHTML = project.status == 1 ? "<span class='btn btn-success'>Aktif</span>" : "<span class='btn btn-danger'>Pasif</span>";

            var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap     pe-0";
            var actionsDiv = document.createElement("div");
            actionsDiv.className = "font-sans-serif btn-reveal-trigger position-static";
            var actionsButton = document.createElement("button");
            actionsButton.className = "btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2";
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
            viewLink.href = "#!";
            viewLink.textContent = "View";
            var exportLink = document.createElement("a");
            exportLink.className = "dropdown-item";
            exportLink.href = "{{URL::to('/')}}/institutional/brands/"+project.id+'/edit';
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
            var removeLink = document.createElement("a");
            removeLink.className = "dropdown-item text-danger";
            removeLink.href = "#!";
            removeLink.textContent = "Sil";
            removeLink.setAttribute("data-brand-id", project.id);
            dropdownMenu.appendChild(viewLink);
            dropdownMenu.appendChild(exportLink);
            dropdownMenu.appendChild(divider);
            dropdownMenu.appendChild(removeLink);
            actionsDiv.appendChild(dropdownMenu);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(checkboxCell);
            row.appendChild(titleCell);
            row.appendChild(slugCell);
            row.appendChild(standOutCell);
            row.appendChild(activeCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });

        $('body').on('click', '.dropdown-item.text-danger', function(e) {
            e.preventDefault(); // Sayfa yenilemeyi engellemek için

            var brandId = $(this).data('brand-id');
            var thisx = $(this);
            // Silme işlemi için bir onay kutusu (Swal) göster
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu markayı silmek istediğinizden emin misiniz?',
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText:'İptal',
                buttons: ['İptal', 'Sil'],
                dangerMode: true,
            }).then(function (willDelete) {
                // Silme işlemi onaylandıysa
                if (willDelete.isConfirmed) {
                    // Silme işlemi için Ajax isteği gönder
                    $.ajax({
                        url: '{{ route("institutional.brands.destroy", ":brandId") }}'.replace(':brandId', brandId),
                        type: 'post',
                        data: {
                            _method:"DELETE",
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            // Başarılı silme işlemi sonrası yapılacak işlemler burada
                            // Örneğin, kullanıcıyı tablodan kaldırabilirsiniz
                            thisx.closest('tr').remove();
                            // Silme başarılı mesajı göster
                            Swal.fire('Başarılı!', 'Marka başarıyla silindi.', 'success');
                        },
                        error: function (xhr) {
                            // Hata durumunda yapılacak işlemler burada
                            swal('Hata!', 'Marka silinirken bir hata oluştu.', 'error');
                        }
                    });
                }
            });
        });

        $('.list-pricing').click(function(){
            var startDate = $('.start_date').val();
            var endDate = $('.end_date').val();
            var tarih1 = new Date(startDate);
            var tarih2 = new Date(endDate);

            // İki tarih arasındaki milisaniye farkını hesaplayın
            var milisaniyeFarki = tarih2 - tarih1;

            // Milisaniyeyi gün olarak çevirin (1 gün = 24 * 60 * 60 * 1000 milisaniye)
            var gunFarki = Math.floor(milisaniyeFarki / (1000 * 60 * 60 * 24));
            var params = {
                type: '1',
            };

            $.ajax({
                url: '{{route("institutional.project.pricing.list")}}', // AJAX isteği gönderilecek URL
                type: 'GET', // GET veya POST olarak isteği ayarlayabilirsiniz
                dataType: 'json', // Yanıt veri türü (json, xml, text, vb.)
                data: params, // Parametreleri gönder
                success: function(data) {
                    var projects = data.data;

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

                        var titleCell = document.createElement("td");
                        titleCell.className = "align-middle ps-3 title";
                        titleCell.textContent = "{{$project->project_title}}";

                        var orderCell = document.createElement("td");
                        orderCell.className = "align-middle ps-3 title";
                        orderCell.textContent = project.order;

                        var slugCell = document.createElement("td");
                        slugCell.className = "align-middle logo";
                        slugCell.textContent = (project.price*gunFarki)+' ₺';

                        var activeCell = document.createElement("td");
                        activeCell.className = "align-middle status";
                        activeCell.innerHTML = project.status == 0 ? "<span class='btn btn-info'>Boşta</span>" : "<span class='btn btn-secondary'>Dolu</span>";

                        var actionsCell = document.createElement("td");
                        actionsCell.className = "align-middle status";
                        actionsCell.innerHTML = project.status == 0 ? "<button class='btn btn-success buy-order' order='"+project.id+"'>Satın Al</button>" : "<button class='btn btn-secondary'>Dolu</button>";

                        row.appendChild(checkboxCell);
                        row.appendChild(titleCell);
                        row.appendChild(orderCell);
                        row.appendChild(slugCell);
                        row.appendChild(activeCell);
                        row.appendChild(actionsCell);

                        tbody.appendChild(row);
                    });

                    $('.buy-order').click(function(){
                      var csrfToken = $('meta[name="csrf-token"]').attr('content'); 
                      $.ajax({
                        url: '{{URL::to("/")}}/institutional/buy_order', // API URL
                        method: 'POST', // GET isteği
                        data:{
                          project_id : {{$project->id}},
                          order : $(this).attr('order'),
                          start_date : $('.start_date').val(),
                          end_date : $('.end_date').val(),
                        },
                        headers: {
                          'X-CSRF-TOKEN': csrfToken // CSRF token'ını başlık olarak ekleyin
                        },
                        dataType: 'json', // Yanıtın JSON formatında olacağını belirtin
                        success: function (data) {
                          if(data.status){
                            $.toast({
                              heading: 'Hata',
                              text: data.message,
                              position: 'top-right',
                              stack: false
                            })
                          }else{
                            $.toast({
                              heading: 'Hata',
                              text: data.message,
                              position: 'top-right',
                              stack: false
                            })
                          }
                        },
                        error: function () {
                            // İstek başarısız olduğunda burası çalışır
                            $('#sonuc').html('İstek başarısız oldu.');
                        }
                      });
                        console.log($(this).attr('order'))
                    })
                },
                error: function(xhr, status, error) {
                    // İstek başarısız olduğunda bu fonksiyon çalışır
                    console.error(xhr.responseText);
                }
            });
        })
    </script>
  @endsection

  