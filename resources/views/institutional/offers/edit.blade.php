@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Kampanya Düzenle</h2>
        <div class="mt-4">
            <div class="row g-4">
                <div class="col-12 col-xl-12 order-1 order-xl-0">
                    <div class="mb-9">
                        <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
                            @if (session()->has('success'))
                                <div class="alert alert-success text-white">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="card-body p-0">
                                <div class="p-4">

                                    <form class="row g-3 needs-validation" novalidate="" method="POST"
                                        action="{{ route('institutional.offers.update', ['offer' => $offer->id]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="id" value="<?=$offer->id?>"/>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">İndirim Tutarı (TL)</label>
                                            <input name="discount_amount" class="form-control" id="validationCustom01"
                                                type="number" min="0" value="{{$offer->discount_amount}}" required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Proje</label>
                                            <select name="project_id" class="form-control" id="project_id" required>
                                                @foreach($projects as $project)
                                                    <option  ption value="{{$project->id}}"{{$project->id == $offer->project_id ? ' selected' : null}}>{{$project->project_title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="validationCustom01">Projeye Ait Konutlar</label>
                                            <a href="#" class="small float-right" id="select-all-ph">Projenin Tüm Konutları</a>
                                            <select name="project_housings[]" class="form-control" id="project_housings" multiple required>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Başlangıç Tarihi</label>
                                            <input type="date" name="start_date" class="form-control" value="{{$offer->start_date}}" id="start_date" required/>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Bitiş Tarihi</label>
                                            <input type="date" name="end_date" class="form-control" value="{{$offer->end_date}}" id="end_date" required/>
                                        </div>

                                        <div id="renderForm"></div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Kaydet</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#select-all-ph').on('click', function()
        {
            $('#project_housings option').prop('selected', true);
        });

        $('#project_id').change(function(){
          var selectedProject = $(this).val(); // Seçilen şehir değerini al
          let t = false;
          // AJAX isteği yap
          $.ajax({
              url: '{{route("institutional.offers.get-project-housings")}}', // Endpoint URL'si (get.counties olarak varsayalım)
              method: 'GET',
              data: { id: selectedProject }, // Şehir verisini isteğe ekle
              dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
              success: function(response) {
                  // Yanıt başarılı olduğunda çalışacak kod
                  var countiesSelect = $('#project_housings'); // counties id'li select'i seç
                  countiesSelect.empty(); // Select içeriğini temizle

                  // Dönen yanıttaki ilçeleri döngüyle ekleyin
                  for (var i = 0; i < response.length; i++) {
                      countiesSelect.append($('<option>', {
                          value: response[i]._ROOM_ORDER, // İlçe ID'si
                          text: response[i].label // İlçe adı
                      }));
                  }

                  if (!t)
                  {
                      $('#project_housings').val({!! $offer->project_housings !!});
                      t = true;
                  }
              },
              error: function(xhr, status, error) {
                  // Hata durumunda çalışacak kod
                  console.error('Hata: ' + error);
              }
          });
      });

      $('#project_id').trigger('change');
    </script>
    @stack('scripts')
@endsection
