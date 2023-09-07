@extends('admin.layouts.master')

@section('content')

<div class="content">
    <h2 class="mb-2 lh-sm">Kullanıcılar</h2>
    <div class="mt-4">
      <div class="row g-4">
        <div class="col-12 col-xl-12 order-1 order-xl-0">
          <div class="mb-9">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
              <div class="card-body p-0">
                <div class="p-4 code-to-copy">
                  <div class="d-flex align-items-center justify-content-end my-3">
                    <div id="bulk-select-replace-element">
                        <a class="btn btn-phoenix-success btn-sm" href="{{route('admin.users.create')}}">
                            <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                            <span class="ms-1">Yeni Kullanıcı Ekle</span>
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
                            <th>İsim Soyisim</th>
                            <th>Email</th>
                            <th>Kullanıcı Tipi</th>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
  @endsection

  @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script>
        var users = @json($users);

        var tbody = document.getElementById("bulk-select-body");
        users.forEach(function(user) {
            var row = document.createElement("tr");

            var checkboxCell = document.createElement("td");
            var checkboxDiv = document.createElement("div");
            checkboxDiv.className = "form-check mb-0 fs-0";
            var checkboxInput = document.createElement("input");
            checkboxInput.className = "form-check-input";
            checkboxInput.type = "checkbox";
            checkboxInput.setAttribute("data-bulk-select-row", JSON.stringify(user));
            checkboxDiv.appendChild(checkboxInput);
            checkboxCell.appendChild(checkboxDiv);

            var titleCell = document.createElement("td");
            titleCell.className = "align-middle ps-3 name";
            titleCell.textContent = user.name;

            var slugCell = document.createElement("td");
            slugCell.className = "align-middle email";
            slugCell.textContent = user.email;

            var typeCell = document.createElement("td");
            typeCell.className = "align-middle type";
            typeCell.innerHTML = user.type == 1 ? "<span class='btn btn-primary'>Normal Kullanıcı</span>" : "<span class='btn btn-info'>Kurumsal Üye</span>";


            var activeCell = document.createElement("td");
            activeCell.className = "align-middle status";
            activeCell.innerHTML = user.status == 1 ? "<span class='btn btn-success'>Aktif</span>" : "<span class='btn btn-danger'>Pasif</span>";

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
            exportLink.href = "{{URL::to('/')}}/admin/users/"+user.id+'/edit';
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
            var removeLink = document.createElement("a");
            removeLink.className = "dropdown-item text-danger";
            removeLink.href = "#!";
            removeLink.textContent = "Sil";
            removeLink.setAttribute("data-user-id", user.id);
            dropdownMenu.appendChild(viewLink);
            dropdownMenu.appendChild(exportLink);
            dropdownMenu.appendChild(divider);
            dropdownMenu.appendChild(removeLink);
            actionsDiv.appendChild(dropdownMenu);
            actionsCell.appendChild(actionsDiv);

            row.appendChild(checkboxCell);
            row.appendChild(titleCell);
            row.appendChild(slugCell);
            row.appendChild(typeCell);
            row.appendChild(activeCell);
            row.appendChild(actionsCell);

            tbody.appendChild(row);
        });

        $('body').on('click', '.dropdown-item.text-danger', function(e) {
            e.preventDefault(); // Sayfa yenilemeyi engellemek için

            var userId = $(this).data('user-id');
            var thisx = $(this);
            // Silme işlemi için bir onay kutusu (Swal) göster
            Swal.fire({
                title: 'Emin misiniz?',
                text: 'Bu kullanıcıyı silmek istediğinizden emin misiniz?',
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
                        url: '{{ route("admin.users.destroy", ":userId") }}'.replace(':userId', userId),
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
                            Swal.fire('Başarılı!', 'Kullanıcı başarıyla silindi.', 'success');
                        },
                        error: function (xhr) {
                            // Hata durumunda yapılacak işlemler burada
                            swal('Hata!', 'Kullanıcı silinirken bir hata oluştu.', 'error');
                        }
                    });
                }
            });
        });
    </script>
  @endsection