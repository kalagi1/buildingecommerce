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
                                <div class="alert alert-success text-white text-white">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger text-white">
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
                                        action="{{ route('institutional.offers.update', ['offer' => $offer->id]) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="id" id="offerID" value="<?= $offer->id ?>" />
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">İndirim Tutarı (TL)</label>
                                            <input name="discount_amount" class="form-control" id="validationCustom01"
                                                type="text" value="{{ number_format($offer->discount_amount, 0, ',', '.') }}"
                                                required="">
                                            <div class="valid-feedback">Looks good!</div>
                                        </div>
                                        
                                        
                                        <div class="col-md-6">
                                            <label for="#" class="form-label">Türü</label>
                                            <select class="form-control" name="type" id="type">
                                                <option value="housing"{{ $offer->type == 'housing' ? ' selected' : null }}>
                                                    Konut</option>
                                                <option value="project"{{ $offer->type == 'project' ? ' selected' : null }}>
                                                    Proje</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 item-housing" {!! $offer->type == 'project' ? "style=\"display: none;\"" : null !!}>
                                            <label class="form-label">Konut</label>
                                            <select name="housing_id" id="housing_id" class="form-control">
                                                <option value="#" selected disabled></option>
                                                @foreach ($housings as $housing)
                                                    <option
                                                        value="{{ $housing->id }}"{{ $offer->housing_id == $housing->id ? ' selected' : null }}>
                                                        {{ $housing->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 item-project" {!! $offer->type == 'housing' ? "style=\"display: none;\"" : null !!}>
                                            <label class="form-label" for="validationCustom01">Proje</label>
                                            <select name="project_id" class="form-control" id="project_id">
                                                @foreach ($projects as $project)
                                                    <option
                                                        value="{{ $project->id }}"{{ $project->id == $offer->project_id ? ' selected' : null }}>
                                                        {{ $project->project_title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 item-project" {!! $offer->type == 'housing' ? "style=\"display: none;\"" : null !!}>
                                            <label class="form-label" for="validationCustom01">Projeye Ait Konutlar</label>
                                            <a href="#" class="small float-right" id="select-all-ph">Projenin Tüm
                                                Konutları</a>
                                                <input type="hidden" name="housing_ids" id="housing_ids">

                                                <div id="project_housings_options" style="height: 200px; overflow-y: scroll;">
                                                    <!-- Seçenekler burada dinamik olarak oluşturulacak -->
                                                </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Başlangıç Tarihi</label>
                                            <input type="date" name="start_date" class="form-control"
                                                value="{{ $offer->start_date }}" id="start_date" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="validationCustom01">Bitiş Tarihi</label>
                                            <input type="date" name="end_date" class="form-control"
                                                value="{{ $offer->end_date }}" id="end_date" required />
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
         // Sayfa yüklendiğinde çalışacak fonksiyon
         $(document).ready(function() {
            // İndirim tutarı alanını dinle
            $('#validationCustom01').on('input', function() {
                // Alanın değerini al
                var discountAmount = $(this).val();
                // Alanın değerini noktalarla güncelle
                $(this).val(addDotsToNumber(discountAmount));
            });
        });

        // Noktalarla sayıyı güncelleyen fonksiyon
        function addDotsToNumber(number) {
            // Sayıyı önce noktasız hale getir
            var numberWithoutDots = number.replace(/[^\d]/g, '');
            // Noktaları ekleyerek güncelle
            return numberWithoutDots.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $('#type').on('change', function() {
            switch ($(this).val()) {
                case "housing":
                    $('.item-housing').slideDown();
                    $('.item-project').slideUp();
                    break;

                case "project":
                    $('.item-housing').slideUp();
                    $('.item-project').slideDown();
                    break;
            }
        });

        $('#select-all-ph').on('change', function() {
            var isChecked = $(this).prop('checked');
            $('#project_housings_options input[type="checkbox"]:not(:disabled)').prop('checked', isChecked);
        });

        $('#project_id').change(function() {
            var selectedProject = $(this).val(); // Seçilen şehir değerini al
            var offerID = $('#offerID').val();
            let t = false;
            var countiesSelect = $('#project_housings_options'); // counties id'li select'i seç

            $.ajax({
                url: '{{ route('institutional.offers.get-project-housings') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    id: selectedProject,
                    offerID:offerID
                },
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                beforeSend: function() {
                    selectedProject = (parseInt(selectedProject) + 1000000).toString();
                    countiesSelect.html('<div class="text-center">"#' + selectedProject +
                        '" numaralı projeye ait konutlar yükleniyor...</div>');
                },
                success: function(response) {
                    $('.item-project-housings').slideDown();
                    countiesSelect.empty(); // Select içeriğini temizle
                    for (var i = 0; i < response.data.room_count; i++) {
                        var optionText = (i + 1) + " No'lu Daire";
                        var optionValue = i + 1;
                        var isChecked = response.data.selected_housings.includes(optionValue.toString());
                        var isDisabled = response.data.differentHousings.includes(optionValue.toString());

                        var checkbox = $('<input>', {
                            type: 'checkbox',
                            name:'checkCampaigns[]',
                            value: optionValue,
                            id: 'housing_' + optionValue,
                            class: 'form-check-input',
                            checked: isChecked,
                            disabled: isDisabled
                        });


                        var label = $('<label>', {
                            for: 'housing_' + optionValue,
                            class: 'form-check-label',
                            text: optionText
                        });

                        var formCheck = $('<div>', {
                            class: 'form-check'
                        });

                        formCheck.append(checkbox);
                        formCheck.append(label);

                        // Checkbox elementini seçeneklere ekle
                        countiesSelect.append(formCheck);
                    }
                    // Projeye ait konutlar seçildiğinde JSON verisi oluştur
                    $('input[type="checkbox"]').on('change', function() {
                        var selectedHousings = [];
                        $('input[type="checkbox"]:checked').each(function() {
                            selectedHousings.push($(this).val());
                        });
                        $('#housing_ids').val(JSON.stringify(selectedHousings));
                    });
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
