@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <h2 class="mb-2 lh-sm">Müşterileriniz için harika bir fırsat oluşturun!</h2>
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
                                    action="{{ route('institutional.offers.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label" for="validationCustom01">İndirim Tutarı (TL)</label>
                                        <input name="discount_amount" class="form-control" id="validationCustom01"
                                            type="text">
                                        <div class="valid-feedback">Looks good!</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="#" class="form-label">Türü</label>
                                        <select class="form-control" name="type" id="type">
                                            <option value="housing">Konut</option>
                                            <option value="project">Proje</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 item-housing">
                                        <label class="form-label">Konut</label>
                                        <select name="housing_id" id="housing_id" class="form-control">
                                            <option value="#" selected disabled>Seçiniz</option>
                                            @foreach ($housings as $housing)
                                                <option value="{{ $housing->id }}">{{ $housing->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 item-project" style="display: none;">
                                        <label class="form-label" for="validationCustom01">Proje</label>
                                        <select name="project_id" class="form-control" id="project_id">
                                            <option value="#" selected disabled>Seçiniz</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->project_title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 item-project-housings" style="display: none;">
                                        <div id="project_housings_wrapper">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select-all-ph">
                                                <label class="form-check-label" for="select-all-ph">
                                                    Tüm Konutları Seç
                                                </label>
                                            </div>
                                            <input type="hidden" name="housing_ids" id="housing_ids">

                                            <div id="project_housings_options" style="height: 200px; overflow-y: scroll;">
                                                <!-- Seçenekler burada dinamik olarak oluşturulacak -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="validationCustom01">Başlangıç Tarihi</label>
                                        <input type="date" name="start_date" class="form-control" id="start_date"
                                            required min="{{ now()->format('Y-m-d') }}">
                                        <div class="invalid-feedback">Başlangıç tarihi bugünden önce olamaz.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="validationCustom01">Bitiş Tarihi</label>
                                        <input type="date" name="end_date" class="form-control" id="end_date" required
                                            min="{{ now()->format('Y-m-d') }}">
                                        <div class="invalid-feedback">Bitiş tarihi başlangıç tarihinden önce olamaz.</div>
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
                    $(".item-project-housings").slideUp();
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
            var countiesSelect = $('#project_housings_options'); // counties id'li select'i seç

            $.ajax({
                url: '{{ route('institutional.offers.get-project-housings') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    id: selectedProject
                },
                dataType: 'json',
                beforeSend: function() {
                    selectedProject = (parseInt(selectedProject) + 1000000).toString();
                    countiesSelect.html('<div class="text-center">"#' + selectedProject +
                        '" numaralı projeye ait konutlar yükleniyor...</div>');
                },
                success: function(response) {
                    $('.item-project-housings').slideDown();
                    countiesSelect.empty();
                    for (var i = 0; i < response.data.room_count; i++) {
                        var optionText = (i + 1) + " No'lu Daire";
                        var optionValue = i + 1;
                        var disabled = response.data.selected_housings.includes(optionValue
                            .toString());

                        var checkbox = $('<input>', {
                            type: 'checkbox',
                            value: optionValue,
                            id: 'housing_' + optionValue,
                            class: 'form-check-input',
                            disabled: disabled
                        });

                        if (disabled) {
                            checkbox.prop('checked', false);
                        }

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
    </script>
@endsection
