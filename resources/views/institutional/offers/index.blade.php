@extends('institutional.layouts.master')

@section('content')

<div class="content">
    <h2 class="mb-2 lh-sm">Kampanyalarım</h2>
    <div class="mt-4">
      <div class="row g-4">
        <div class="col-12 col-xl-12 order-1 order-xl-0">
          <div class="mb-9">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
              <div class="card-body p-0">
                <div class="p-4 code-to-copy">
                  <div class="d-flex align-items-center justify-content-end my-3">
                    <div id="bulk-select-replace-element">
                        <a class="btn btn-phoenix-success btn-sm" href="{{route('institutional.offers.create')}}">
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span class="ms-1">Yeni Kampanya Ekle</span>
                        </a>
                    </div>
                  </div>
                  <div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":10,"pagination":true}'>
                    @if (session()->has('success'))
                        <div class="alert alert-success text-white text-white">
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
                            <th>İndirim Tutarı</th>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi</th>
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
  </div>

  @endsection

  @section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  @endsection

  @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        var projects = @json($offers);

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

            var aCell = document.createElement("td");
            aCell.className = "align-middle ps-3 title";
            aCell.textContent = project.discount_amount;

            var sdCell = document.createElement("td");
            sdCell.className = "align-middle ps-3 title";
            sdCell.textContent = project.start_date;

            var edCell = document.createElement("td");
            edCell.className = "align-middle ps-3 title";
            edCell.textContent = project.end_date;

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
            var dropdownMenu = document.createElement("div");
            dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
            var exportLink = document.createElement("a");
            exportLink.className = "btn btn-primary";
            exportLink.href = "{{URL::to('/')}}/institutional/offers/"+project.id+'/edit';
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

            row.appendChild(checkboxCell);
            row.appendChild(aCell);
            row.appendChild(sdCell);
            row.appendChild(edCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });

        $('body').on('click', '.dropdown-item.text-danger', function(e) {
            e.preventDefault(); // Sayfa yenilemeyi engellemek için

            var projectId = $(this).data('project-id');
            var thisx = $(this);
            console.log(projectId);
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
                        url: '{{ route("institutional.offers.delete", ":projectId") }}'.replace(':projectId', projectId),
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
                            Swal.fire('Başarılı!', 'Proje başarıyla silindi.', 'success');
                        },
                        error: function (xhr) {
                            // Hata durumunda yapılacak işlemler burada
                            swal('Hata!', 'Proje silinirken bir hata oluştu.', 'error');
                        }
                    });
                }
            });
        });
    </script>
  @endsection
