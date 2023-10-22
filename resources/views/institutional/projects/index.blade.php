@extends('institutional.layouts.master')

@section('content')

<div class="content">
    <h2 class="mb-2 lh-sm">Projelerim</h2>
    <div class="mt-4">
      <div class="row g-4">
        <div class="col-12 col-xl-12 order-1 order-xl-0">
          <div class="mb-9">
            <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
              <div class="card-body p-0">
                <div class="p-4 code-to-copy">
                  <div class="d-flex align-items-center justify-content-end my-3">
                    <div id="bulk-select-replace-element">
                        <a class="btn btn-phoenix-success btn-sm" href="{{route('institutional.projects.create')}}">
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
                  <div id="tableExample" data-list='{"valueNames":["name","email","age"],"page":10,"pagination":true}'>
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
                            <th>Proje Kapak Fotoğrafı</th>
                            <th>Öne Çıkar</th>
                            <th>Statü</th>
                            <th>İşlemler</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  @endsection

  @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js" integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        var projects = @json($projects);
        @if(request('update_item'))
        $.toast({
          heading: 'Başarılı',
          text: 'Başarıyla projeyi güncellediniz',
          position: 'top-right',
          stack: false
        })
        @endif
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
            standOutCell.innerHTML =  "<a href='{{URL::to('/')}}/institutional/project_stand_out/"+project.id+"' class='badge badge-info'>Öne Çıkar</a>";

            var activeCell = document.createElement("td");
            activeCell.className = "align-middle status";
            activeCell.innerHTML = project.status == 1 ? '<span class="badge badge-success">Aktif</span>' : project.status == 2 ? '<span class="badge badge-danger">Admin Onayı Bekliyor</span>' : project.status == 3 ? '<span class="badge badge-danger">Admin Tarafından Reddedildi</span>' : '<span class="badge badge-danger">Pasif</span>';

            var actionsCell = document.createElement("td");
            actionsCell.className = "align-middle white-space-nowrap pe-0";
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
         
            var dropdownMenu = document.createElement("div");
            dropdownMenu.className = "dropdown-menu dropdown-menu py-2";
            var viewLink = document.createElement("a");
            viewLink.className = "btn btn-warning";
            viewLink.href = "{{URL::to('/')}}/institutional/projects/"+project.id+'/logs';
            viewLink.textContent = "Loglar";
            var exportLink = document.createElement("a");
            exportLink.className = "btn btn-success ml-3";
            exportLink.href = "{{URL::to('/')}}/institutional/edit_project_v2/"+project.slug;
            exportLink.textContent = "Düzenle";
            var divider = document.createElement("div");
            divider.className = "dropdown-divider";
            var removeLink = document.createElement("a");
            removeLink.className = "btn btn-danger ml-3";
            removeLink.href = "#!";
            removeLink.textContent = "Sil";
            removeLink.setAttribute("data-project-id", project.id);
          
            actionsDiv.appendChild(viewLink);
            actionsDiv.appendChild(exportLink);
            actionsDiv.appendChild(removeLink);
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
                        url: '{{ route("institutional.projects.destroy", ":projectId") }}'.replace(':projectId', projectId),
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

    <style>
      .ml-3
      {
        margin-left: 20px
      }

      .badge-success{
        background-color: green
      }

      .badge-danger{
        background-color: red
      }

      .badge-info {
        background-color: #0097eb
      }
    </style>
  @endsection
