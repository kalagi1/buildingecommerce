@extends('client.layouts.master')

@section('content')
    <style>
        /* css */
        .trip-search select {
            border: 1px solid #CCC;
            border-radius: 8px;
        }

        input[type=radio] {
            appearance: none;
            background: white;
            border: 2px solid #dddddd;
            border-radius: 100%;
        }

        .filtreArea {
            max-height: 150px;
            overflow-y: auto;
        }

        input[type=radio]:checked {
            background: #0A0A0A;
        }

        .widget-boxed-header h6 {
            font-weight: bold !important;
            color: #000;
        }

        @media (min-width: 768px) {
            .filters-input-area {
                display: block !important;
            }
        }

        @media (max-width: 767px) {

            #clear-filters,
            #close-filters {
                border: 1px solid #CCC;
                width: 90%;
                padding: 10px !important;
                margin: 0 auto;
                margin: 10px auto;
                font-size: 11px;
            }

            .filters-input-area {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 999999999;
                background-color: white;
                box-shadow: 0 0 48px rgba(0, 0, 0, .3);
                overflow-y: scroll;
                padding-top: 0 !important;
            }

            .filters-input-area .mobile-button {
                border-color: #EEE;
                padding: 0 1rem;
                margin-top: 10px;
                border-radius: 0 !important
            }

            .filters-input-area .mobile-title widget-boxed-header {
                background: #E0E0E0;
                border: 0;
                padding: 1rem;
            }

            .filters-input-area .mobile-input {
                border-radius: 0 !important;
            }

            .filters-input-area .bathroom-count-item {
                border-radius: 0 !important;
            }

            .filters-input-area .current-page {
                border-radius: 0 !important;
            }

            .mobile-header {
                background: #2d67bd;
                color: #FFF;
                padding: 12px 16px;
            }
        }
    </style>
    @php
        function convertMonthToTurkishCharacter($date)
        {
            $aylar = [
                'January' => 'Ocak',
                'February' => 'Şubat',
                'March' => 'Mart',
                'April' => 'Nisan',
                'May' => 'Mayıs',
                'June' => 'Haziran',
                'July' => 'Temmuz',
                'August' => 'Ağustos',
                'September' => 'Eylül',
                'October' => 'Ekim',
                'November' => 'Kasım',
                'December' => 'Aralık',
                'Monday' => 'Pazartesi',
                'Tuesday' => 'Salı',
                'Wednesday' => 'Çarşamba',
                'Thursday' => 'Perşembe',
                'Friday' => 'Cuma',
                'Saturday' => 'Cumartesi',
                'Sunday' => 'Pazar',
                'Jan' => 'Oca',
                'Feb' => 'Şub',
                'Mar' => 'Mar',
                'Apr' => 'Nis',
                'May' => 'May',
                'Jun' => 'Haz',
                'Jul' => 'Tem',
                'Aug' => 'Ağu',
                'Sep' => 'Eyl',
                'Oct' => 'Eki',
                'Nov' => 'Kas',
                'Dec' => 'Ara',
            ];
            return strtr($date, $aylar);
        }

        function getData($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a[0];
        }

        function getImage($housing, $key)
        {
            $housing_type_data = json_decode($housing->housing_type_data);
            $a = $housing_type_data->$key;
            return $a;
        }
    @endphp
    <section class="properties-right list featured portfolio blog pt-5 bg-white">
        <div class="container">

            <div class="row project-filter-reverse pb-5">
                <aside class="col-lg-3 col-md-12 order-2 order-md-1 ">
                    <div class="filters-input-area" style="display: none;">
                        <div style="position: relative;" class="d-flex mobile-header">
                            <svg height="24px" id="Layer_1" onclick="$(this).parent().parent().slideToggle();"
                                class="d-md-none"
                                style="position: absolute; left: 16px; enable-background:new 0 0 512 512;cursor: pointer;"
                                version="1.1" viewBox="0 0 512 512" width="24px" xml:space="preserve"
                                xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <path fill="#FFF"
                                    d="M437.5,386.6L306.9,256l130.6-130.6c14.1-14.1,14.1-36.8,0-50.9c-14.1-14.1-36.8-14.1-50.9,0L256,205.1L125.4,74.5  c-14.1-14.1-36.8-14.1-50.9,0c-14.1,14.1-14.1,36.8,0,50.9L205.1,256L74.5,386.6c-14.1,14.1-14.1,36.8,0,50.9  c14.1,14.1,36.8,14.1,50.9,0L256,306.9l130.6,130.6c14.1,14.1,36.8,14.1,50.9,0C451.5,423.4,451.5,400.6,437.5,386.6z" />
                            </svg>
                            <div class="d-md-none" style="margin: 0 auto; font-weight: bold; color: #FFF;">FİLTRELE</div>
                            <!-- Search Fields -->
                        </div>

                        <div>

                            <div>
                                <a id="clear-filters"
                                    style="font-size: 12px;text-decoration: underline !important;color: black;cursor: pointer;margin-bottom: 10px;text-align: left;width: 100%;display: block;">Temizle</a>
                                <div class="trip-search">
                                    <div class="widget-boxed-header mobile-title widget-boxed-header"
                                        style="margin-bottom: 0 !important">
                                        <span>Adres</span>
                                    </div>
                                    <div class="mt-md-2">
                                        <select id="city" class="bg-white filter-now mobile-button">
                                            <option value="#" class="selected" selected disabled>İl</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->title }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="mt-md-2">
                                        <select id="county" class="bg-white filter-now mobile-button">
                                            <option value="#" class="selected" selected disabled>İlçe</option>
                                        </select>


                                    </div>
                                    <div class="mt-md-2">
                                        <select id="neighborhood" class="bg-white filter-now mobile-button">
                                            <option value="#" class="selected" selected disabled>Mahalle</option>
                                        </select>


                                    </div>
                                </div>


                                @if ($projects)
                                    <div class="trip-search mt-md-2">
                                        <div class="widget-boxed-header mobile-title widget-boxed-header">
                                            <span>Proje Durumu</span>
                                        </div>
                                        <div class="mt-md-2">
                                            <select id="project_type" class="form-control bg-white filter-now">
                                                <option value="#" selected disabled>Proje Durumu</option>
                                                <option value="2">Tamamlanan Projeler</option>
                                                <option value="3">Devam Eden Projeler</option>
                                                <option value="5">Topraktan Projeler</option>
                                            </select>
                                        </div>
                                    </div>
                                @endif


                                @foreach ($filters as $filter)
                                    <div id="room_count_field" class="room_count_field">

                                        @if ($filter['type'] != 'text')
                                            <div class="trip-search mt-md-2">
                                                <div class="head widget-boxed-header mobile-title widget-boxed-header"
                                                    onclick="toggleFilter(this)">
                                                    <span>{!! $filter['label'] !!}</span>
                                                </div>
                                                <div class="mt-md-2 filtreArea" style="display: none !important;">
                                                    @foreach ($filter['values'] as $key => $value)
                                                        @if (isset($filter['toggle']) && $filter['toggle'] == true)
                                                     
                                                        
                                                        <!-- Switch-slider öğesi -->
                                                        <div class="mb-2 d-flex align-items-center">
                                                            <label class="switch-slider">
                                                                <input name="{{ $filter['name'] }}[]" type="checkbox" value="{{ $value->value }}" class="filter-now form-control switch" id="{{ $filter['name'] . $key }}">
                                                                <span class="slider"></span>
                                                            </label>
                                                            <label for="{{ $filter['name'] . $key }}" class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                                                        </div>
                                                        
                                                            @else
                                                            @if ($filter['type'] == 'select')
                                                            @if ($key != 0)
                                                                <div class="mb-2 d-flex align-items-center">
                                                                    <input name="{{ $filter['name'] }}[]" type="checkbox"
                                                                        value="{{ $value->value }}"
                                                                        class="filter-now form-control"
                                                                        id="{{ $filter['name'] . $key }}">
                                                                    <label for="{{ $filter['name'] . $key }}"
                                                                        class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                                                                </div>
                                                            @endif
                                                        @elseif($filter['type'] == 'checkbox-group')
                                                            <div class="mb-2 d-flex align-items-center">
                                                                <input name="{{ $filter['name'] }}[]" type="checkbox"
                                                                    value="{{ $value->value }}"
                                                                    class="filter-now form-control"
                                                                    id="{{ $filter['name'] . $key }}">
                                                                <label for="{{ $filter['name'] . $key }}"
                                                                    class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                                                            </div>
                                                        @endif
                                                        @endif
                                                     
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <script>
                                            function toggleFilter(element) {
                                                var filterArea = element.nextElementSibling; // Filtre alanı div'i

                                                if (filterArea.style.display === 'none') {
                                                    filterArea.style.display = 'block';
                                                } else {
                                                    filterArea.style.display = 'none';
                                                }
                                            }
                                        </script>


                                        @if ($filter['type'] == 'text')
                                            <div class="trip-search mt-md-2">
                                                <div class="head d-flex" onclick="toggleFilterDiv(this)">
                                                    <div class="widget-boxed-header mobile-title widget-boxed-header">
                                                        <span>{!! $filter['label'] !!}</span>
                                                    </div>

                                                </div>
                                                <div class="d-flex align-items-center mt-md-2"
                                                    style="display: none !important;">
                                                    @if ($filter['text_style'] == 'min-max')
                                                        <span id="slider-range-value1">
                                                            <input type="text"
                                                                name="{{ str_replace('[]', '', $filter['name']) }}-min"
                                                                id="{{ str_replace('[]', '', $filter['name']) }}-min"
                                                                min="0" placeholder="Min"
                                                                class="filter-now form-control price-only">
                                                        </span>
                                                        <i class="fa fa-solid fa-minus mx-2 dark-color icon"></i>
                                                        <span id="slider-range-value2">
                                                            <input type="text"
                                                                id="{{ str_replace('[]', '', $filter['name']) }}-max"
                                                                min="0" placeholder="Max"
                                                                class="filter-now form-control price-only"
                                                                name="{{ str_replace('[]', '', $filter['name']) }}-max">
                                                        </span>
                                                    @else
                                                        <span class="w-100">
                                                            <input type="text"
                                                                name="{{ str_replace('[]', '', $filter['name']) }}"
                                                                id="{{ str_replace('[]', '', $filter['name']) }}"
                                                                class="filter-now form-control">
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif

                                        <script>
                                            function toggleFilterDiv(element) {
                                                var filterContent = $(element).parent().find('.mt-md-2');
                                                var filterIcon = $(element).find('#filter-icon');

                                                if (filterContent.css('display') === 'none') {
                                                    filterContent.attr('style', 'display: flex !important');
                                                    filterIcon.attr('style', 'transform: rotate(180deg) !important');
                                                } else {
                                                    filterContent.attr('style', 'display: none !important');
                                                    filterIcon.attr('style', 'transform: rotate(0deg) !important');
                                                }
                                            }

                                            function toggleFilter(element) {
                                                var filterContent = $(element).parent().find('.mt-md-2');
                                                var filterIcon = $(element).find('#filter-icon');

                                                if (filterContent.css('display') === 'none') {
                                                    filterContent.attr('style', 'display: block !important');
                                                    filterIcon.attr('style', 'transform: rotate(180deg) !important');
                                                } else {
                                                    filterContent.attr('style', 'display: none !important');
                                                    filterIcon.attr('style', 'transform: rotate(0deg) !important');
                                                }
                                            }
                                        </script>



                                    </div>
                                @endforeach

                            </div>

                            <button type="button" class="btn bg-white btn-lg btn-block mt-md-2 mb-4e btn-transition"
                                style="    border: 1px solid #CCC;
                            font-size: 12px;
                            position: fixed;
                            bottom: 10px;
                            width: 255px;
                            background: #EA2B2E !important;
                            color: white;
                            z-index:9999"
                                id="submit-filters">Filtrele</button>

                            <button type="button"
                                class="d-md-none d-lg-none btn bg-white btn-lg btn-block mt-md-2 mb-4e btn-transition"
                                style="border: 1px solid #CCC;" id="clear-filters">Temizle</button>

                            <button type="button" onclick="$('.filters-input-area').slideToggle();"
                                style="background: #e54242 !important"
                                class="btn btn-secondary btn-lg btn-block mt-md-2 d-md-none mb-4"
                                id="close-filters">Kapat</button>

                        </div>

                    </div>
                </aside>

                <div class="col-lg-9 col-md-12 blog-pots order-1">
                    <section class="headings-2 pt-0 d-md-flex" style="display: grid;">
                        <div class="brand-head" style="padding-top: 0">
                            <div class="brands-square" style="position: relative; top: 0; left: 0">
                                <p class="brand-name"><a href="{{ url('/') }}" style="color: black">Anasayfa</a>
                                </p>
                                @if ($slugName)
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name" style="color: black">{{ $slugName }}</p>
                                @endif
                                @if ($housingTypeSlugName)
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name" style="color: black">{{ $housingTypeSlugName }}</p>
                                @endif
                                @if ($optName)
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name" style="color: black">{{ $optName }}</p>
                                @endif
                                @if ($housingTypeName)
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name" style="color: black">{{ $housingTypeName }}</p>
                                @endif
                                @if ($checkTitle)
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name" style="color: black">
                                        {{ ucwords(str_replace('-', ' ', $checkTitle)) }}</p>
                                @endif

                            </div>
                        </div>


                        <div id="sorting-options" class="d-flex align-items-center ml-0 ml-md-auto mr-md-0"
                            style="gap: 16px;">

                            <div onclick="$('.filters-input-area').slideToggle();"
                                style="background: #e54242 !important; padding: 6px; border-radius: 5px;cursor: pointer;"
                                class="d-md-none">
                                <svg class="rounded-sm" enable-background="new 0 0 32 32" width="24px" height="24px"
                                    id="Editable-line" version="1.1" viewBox="0 0 32 32" xml:space="preserve"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <path
                                        d="  M3.241,7.646L13,19v9l6-4v-5l9.759-11.354C29.315,6.996,28.848,6,27.986,6H4.014C3.152,6,2.685,6.996,3.241,7.646z"
                                        fill="none" id="XMLID_6_" stroke="#FFF" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2" />
                                </svg>
                            </div>

                            <select id="sort-select" class="form-control">
                                <option value="sort">Sırala</option>
                                <option value="price-asc">Fiyata göre (Önce en düşük)</option>
                                <option value="price-desc">Fiyata göre (Önce en yüksek)</option>
                                <option value="date-asc">Tarihe göre (Önce en eski ilan)</option>
                                <option value="date-desc">Tarihe göre (Önce en yeni ilan)</option>
                            </select>
                            <!-- Button trigger modal -->

                        </div>
                    </section>
                    <section class="popular-places home18 mt-3" style="padding-top:0 !important">
                        <div class="container">
                            <div class="mobile-hidden">
                                <div class="row pp-row">
                                </div>
                            </div>
                            <div class="mobile-show">
                                <div class="row pp-col">
                                </div>
                            </div>

                        </div>
                    </section>
                    {{-- <section id="pages" class="d-flex justify-content-center" style="gap: 12px;">
                    </section> --}}

                </div>

            </div>

        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Search Fields -->
                    <div class="widget-boxed main-search-field">
                        <div class="trip-search">
                            <div class="head d-flex">
                                <span>Adres </span>
                                <span class="ml-auto" onclick="$(this).parent().parent().find('.mt-4').slideToggle();">
                                    <svg width="16px" height="16px" viewBox="0 0 384 512"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-4">
                                <select id="city" class="bg-white filter-now">
                                    <option value="#" selected disabled>İl</option>
                                    @foreach ($cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-4">
                                <select id="county" class="bg-white filter-now">
                                    <option value="#" selected disabled>İlçe</option>
                                </select>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        let last_page;
        let current_page = 1;
        let bathroom_count;

        var button = document.getElementById('submit-filters');


        window.addEventListener('scroll', function() {
            var scrollPosition = window.scrollY;

            if (scrollPosition > 200) {
                button.classList.add('scroll-up');
            } else {
                button.classList.remove('scroll-up');
            }
        });

        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $('.bathroom-count-item').on('click', function() {
            $('.bathroom-count-item').removeClass('bg-dark').removeClass('text-white');
            $(this).addClass('bg-dark').addClass('text-white');
            bathroom_count = $(this).text();
        });

        $('.price-only').keyup(function() {
            $('.price-only .error-text').remove();
            if ($('.price-only').val().replace('.', '').replace('.', '').replace('.', '').replace('.', '') !=
                parseInt($('.price-only').val().replace('.', '').replace('.', '').replace('.', '').replace('.', '')
                    .replace('.', ''))) {
                if ($('.price-only').closest('.form-group').find('.error-text').length > 0) {
                    $('.price-only').val("");
                } else {
                    $(this).closest('.form-group').append(
                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $('.price-only').val("");
                }

            } else {
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                console.log(inputValue);
                $(this).val(inputValue)
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })

        $('#city').on('change', function() {
            $.ajax({
                method: "GET",
                url: "{{ url('get-counties') }}/" + $(this).val(),
                success: function(res) {
                    $('#county').empty();
                    $('#county').append('<option value="#" disabled>İlçe</option>');
                    res.forEach((e) => {
                        $('#county').append(
                            `<option value="${e.ilce_key}">${e.ilce_title}</option>`
                        );
                        $('#county').val('#');
                    });
                }
            });
        });

        $('#county').on('change', function() {
            $.ajax({
                method: "GET",
                url: "{{ url('get-neighborhoods-for-client') }}/" + $(this).val(),
                success: function(res) {
                    $('#neighborhood').empty();
                    $('#neighborhood').append('<option value="#" disabled>Mahalle</option>');
                    res.forEach((e) => {
                        $('#neighborhood').append(
                            `<option value="${e.id}">${e.title}</option>`
                        );
                        $('#neighborhood').val('#');
                    });
                }
            });
        });

        function ucfirst(str) {
            if (typeof str !== 'string') return '';
            return str.charAt(0).toUpperCase() + str.slice(1);
        }


        function toTitleCase(str) {
            return str.replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
        }

        function drawList(filters = {}) {
            function formatDate(rawDate) {
                const options = {
                    month: 'long',
                    day: 'numeric',
                    year: 'numeric'
                };
                const date = new Date(rawDate);
                return new Intl.DateTimeFormat('tr-TR', options).format(date);
            }

            var slug = @json($slug ?? null);
            var type = @json($housingTypeParentSlug ?? null);
            var title = @json($housingTypeSlug ?? null);
            var optional = @json($opt ?? null);
            var checkTitle = @json($checkTitle ?? null);

            var data = Object.assign({}, filters, {
                _token: "{{ csrf_token() }}",
                slug: slug,
                type: type,
                title: title,
                optional: optional,
                checkTitle: checkTitle
            });

            let currentData = {};

            Object.keys(data).map(e => {
                if (data[e])
                    currentData[e] = data[e];
            });

            $.ajax({
                method: "POST",
                url: "{{ route($secondhandHousings ? 'get-rendered-secondhandhousings' : 'get-rendered-projects') }}",
                data: currentData,
                success: function(response) {
                    $('.pp-row').empty();
                    $('.pp-col').empty();
                    $('#pages').empty();

                    last_page = response.last_page;

                    $('#pages').append(`
                        <a class="btn btn-primary prev-page">Önceki</a>
                    `);

                    for (var i = 1; i <= response.last_page; ++i) {
                        $('#pages').append(`
                            <a class="btn btn-outline-primary filter-page" data-page="${i}" ${response.current_page == i ? 'style="color: white;"' : 'style="background: transparent;"'}>${i}</a>
                        `);
                    }

                    $('#pages').append(`
                        <a class="btn btn-primary next-page">Sonraki</a>
                    `);

                    if (current_page == '1')
                        $('.prev-page').addClass('d-none');
                    else
                        $('.prev-page').removeClass('d-none');

                    if (current_page == last_page)
                        $('.next-page').addClass('d-none');
                    else
                        $('.next-page').removeClass('d-none');

                    if (response.data.length > 0) {

                        var assetPath = "{{ asset('images/sc.png') }}";

                        response.data.forEach((res) => {
                            if (typeof res === "boolean")
                                return true;

                            @if (!$secondhandHousings)
                                $('.pp-row').append(
                                    `
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-12 projectMobileMargin" data-aos="zoom-in" data-aos-delay="150" style="height:200px">
                                        <div class="project-single no-mb aos-init aos-animate" style="height:100%" data-aos="zoom-in" data-aos-delay="150">
                                            <div class="listing-item compact" style="height:100%">
                                                <a href="${res.url}" class="listing-img-container">
                                                    <img class="project_brand_profile_image" src="${res.image}" style="border-radius:7px;" alt="">
                                                    <div class="listing-img-content" style="padding-left:10px;text-transform:uppercase;">
                                                        <span class="badge badge-phoenix text-left">${res.title} <span class="d-block"><small>${res.city.title} / ${res.county.ilce_title}</small></span></span>
                                                    
                                                    </div>
                                                    <img src="${res.image}" alt=""
                                                    style="height:100%;object-fit:cover">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    `
                                );
                                $('.pp-col').append(
                                    `
                                        <div class="col-sm-12 col-md-6 col-lg-6 col-12 projectMobileMargin" data-aos="zoom-in" data-aos-delay="150" style="height:200px">
                                            <div class="project-single no-mb aos-init aos-animate" style="height:100%" data-aos="zoom-in" data-aos-delay="150">
                                                <div class="listing-item compact" style="height:100%">
                                                    <a href="${res.url}" class="listing-img-container" >
                                                        <img class="project_brand_profile_image" src="${res.image}" alt="" style="border-radius:7px;">
                                                        <div class="listing-img-content" style="padding-left:10px;text-transform:uppercase;">
                                                            <span class="badge badge-phoenix text-left">${res.title} <span class="d-block"><small>${res.city.title} / ${res.county.ilce_title}</small></span></span>
                                                        
                                                        </div>
                                                        <img src="${res.image}" alt=""
                                                        style="height:100%;object-fit:cover">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    `
                                );
                            @else
                                var featuredHtml = '';
                                if (res.doping_time) {
                                    var featuredHtml =
                                        '<div class="homes-tag button alt featured">Sponsorlu </div>';
                                }

                                function kisalt(text, uzunluk) {
                                    if (typeof text == "string" && text.length > uzunluk) {
                                        return text.substring(0, uzunluk - 3) + "...";
                                    }
                                    return text;
                                }



                                // Metni kırp ve üç nokta ekle
                                var kisaltilmisBaslik = kisalt(res.title, 45);
                                $('.pp-row').append(`
                                    <div class="agents-grid col-md-4" data-aos="fade-up" data-aos-delay="150">
                                        <a href="${res.housing_url}" tabindex="0" class="text-decoration-none">
                                            <div class="landscapes">
                                                <div class="project-single">
                                                    <div class="project-inner project-head">
                                                        <div class="homes">
                                                            <!-- homes img -->
                                                            <div class="homes-img">
                                                                ${featuredHtml}
                                                                <img src="${res.image}" alt="${res.housing_type_title}" class="img-responsive">
                                                            </div>
                                                        </div>
                                                        <div class="button-effect">
                                                            <!-- Örneğin Kalp İkonu -->
                                                            <div href="" class="btn toggle-favorite bg-white ${res.in_favorites ? 'bg-white' : ''}" data-housing-id="${res.id}">
                                                                <i class="fa fa-heart-o ${res.in_favorites ? 'text-danger' : ''}"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- homes content -->
                                                    <div class="homes-content px-3 py-3" style="${res.sold ? 'background: #EEE !important;' : ''}">
                                                        <!-- homes address -->
                                                        <a href="${res.housing_url}">
                                                            <h4>${kisaltilmisBaslik}</h4>
                                                        </a>
                                                        <p class="homes-address mb-3">
                                                            <a href="${res.housing_url}">
                                                                <i class="fa fa-map-marker"></i><span>${res.city} ${" / "} ${res.county} ${" / "} ${res.neighborhood}</span>
                                                            </a>
                                                        </p>
                                                        <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: space-evenly;align-items: center;width: 100%;">
                                                            ${res.column1 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column1)} ${res.column1_additional ? res.column1_additional : " "}</span></li>` : ''}
                                                            ${res.column2 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column2)} ${res.column2_additional ? res.column2_additional : " "}</span></li>` : ''}
                                                            ${res.column3 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column3)} ${res.column3_additional ? res.column3_additional : " "}</span></li>` : ''}
                                                                                                                    </ul>

                                                        <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: space-between">
                                                            <li style="font-size: 15px; font-weight: 700; flex: 1;height:28px" class="priceFont">
                                                                ${res.step2_slug !== "gunluk-kiralik" ?
                                                                    res.offSale || (res.action === 'payment_await' || res.action === 'sold') ? " "
                                                                    : numberFormat(res.housing_type.price) + " ₺"
                                                                    : numberFormat(res.housing_type.daily_rent) + " ₺" + " <span  style='font-size:12px; color:#EA2B2E !important' class='mobilePriceStyle'>/ 1 Gece</span>"
                                                                }
                                                            </li>
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: center;">
                                                            ${res.step2_slug !== "gunluk-kiralik" ?
                                                                res.offSale ?
                                                                    `<button
                                                                                                            class="btn second-btn " 
                                                                                                            style="background: #EA2B2E !important;width:100%;color:White">Satıldı
                                                                                                        </button>`
                                                                    :
                                                                    res.action === 'payment_await' ?
                                                                        `<button
                                                                                                                class="btn second-btn " 
                                                                                                                style="background: orange !important;width:100%;color:White">Onay Bekleniyor
                                                                                                            </button>`
                                                                        :
                                                                        res.action === 'sold' ?
                                                                            `<button
                                                                                                                    class="btn second-btn " 
                                                                                                                    style="width: 100%; border: none; background:#EA2B2E !important; border-radius: 10px; padding: 5px 0px; color: white;">Satıldı
                                                                                                                </button>`
                                                                            :
                                                                `<button class="CartBtn ${res.in_cart ? 'bg-success text-white' : ''}" data-type='housing'
                                                                                                        data-id='${res.id}'>
                                                                                                        <span class="IconContainer">
                                                                                                            <img src="{{ asset('sc.png') }}" alt="">
                                                                                                        </span>
                                                                                                        <span class="text text-white">${res.in_cart ? 'Sepete Eklendi' : 'Sepete Ekle'}</span>
                                                                                                    </button>` :
                                                            `<button onclick="redirectToReservation('${res.id}')" class="reservationBtn">
                                                                                                    <span class="IconContainer">
                                                                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                                                                    </span>
                                                                                                    <span class="text" style="color: white;">Rezervasyon Yap</span>
                                                                                                </button>`
                                                            }
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            `);


                                $('.pp-col').append(`
                                <div class="d-flex" style="flex-wrap: nowrap;width:100%">
                                    <div class="align-items-center d-flex " style="padding-right:0; width: 110px;">
                                        <div class="project-inner project-head">
                                            <a href="${res.housing_url}">
                                                <div class="homes">
                                                    <!-- homes img -->
                                                    <div class="homes-img h-100 d-flex align-items-center"
                                                        style="width: 110px; height: 128px;">
                                                        <img src="${res.image}" alt="${res.title}" class="img-responsive"
                                                            style="height: 100px !important;">
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="w-100" style="padding-left:0;">
                                        <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                                            <a style="text-decoration: none;height:100%" href="${res.housing_url}">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h4>
                                                    ${res.title}
                                                </h4>
                                                <span class="btn toggle-favorite bg-white" data-housing-id="${res.id}" style="color: white;">
                                                        <i class="fa fa-heart-o"></i>
                                                    </span>
                                                    </div>
                                              
                                            </a>
                                            <div class="d-flex" style="align-items:Center">
                                                <div class="d-flex" style="gap: 8px;">
                                                

                                                                        ${res.step2_slug !== "gunluk-kiralik" ?
                                                    res.offSale ?
                                                        `  <button class="btn second-btn  mobileCBtn" 
                                                                    style="background: #EA2B2E !important;width:100%;color:White">

                                                                    <span class="text">Satıldı</span>
                                                                </button>`
                                                        :
                                                        res.action === 'payment_await' ?
                                                            `<button
                                                                                                    class="btn mobileCBtn second-btn CartBtn" 
                                                                                                    style="background: orange !important;width:100%;color:White">Onay Bekleniyor
                                                                                                </button>`
                                                            :
                                                            res.action === 'sold' ?
                                                                `<button
                                                                                                        class="btn mobileCBtn second-btn CartBtn" 
                                                                                                        style="width: 100%; border: none; background:#EA2B2E !important; border-radius: 10px; padding: 5px 0px; color: white;">Satıldı
                                                                                                    </button>`
                                                                :
                                                                `<button class="CartBtn mobileCBtn ${res.in_cart ? 'bg-success text-white' : ''}" data-type='housing'
                                                                                                        data-id='${res.id}'>
                                                                                                        <span class="IconContainer">
                                                                                                            <img src="{{ asset('sc.png') }}" alt="">
                                                                                                        </span>
                                                                                                        <span class="text text-white">${res.in_cart ? 'Sepete Eklendi' : 'Sepete Ekle'}</span>
                                                                                                    </button>` :
                                                                    `<button onclick="redirectToReservation('${res.id}')" class="reservationBtn mobileCBtn CartBtn">
                                                                                                            <span class="IconContainer">
                                                                                                                <img src="{{ asset('sc.png') }}" alt="">
                                                                                                            </span>
                                                                                                            <span class="text">Rezervasyon Yap</span>
                                                                                                        </button>`
                                                                }
                                                                    </div>
                                                                    <span class="ml-auto text-primary priceFont">
                                                                        ${
                                                        res.step2_slug !== "gunluk-kiralik"
                                                        ? res.offSale || (res.action === 'payment_await' || res.action === 'sold')
                                                            ? " "
                                                            : numberFormat(res.housing_type.price) + " ₺"
                                                        : numberFormat(res.housing_type.daily_rent) + " ₺" + " <span  style='font-size:12px; color:Red' class='mobilePriceStyle'>/ 1 Gece</span>"
                                                    }
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                                    <div class="d-flex justify-content-between align-items-center"
                                style="height: 100%;padding: 10px">
                                    <ul class="d-flex align-items-center h-100"
                                    style="list-style: none;padding:0;font-weight:600;justify-content:start;margin-bottom:0 !important">
                                           
                                                    ${res.column1 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column1)} ${res.column1_additional ? res.column1_additional : " "}</span></li>` : ''}
                                                    ${res.column2 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column2)} ${res.column2_additional ? res.column2_additional : " "}</span></li>` : ''}
                                                    ${res.column3 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column3)} ${res.column3_additional ? res.column3_additional : " "}</span></li>` : ''}
                                        </ul>
                                        <span style="font-size: 11px !important">${res.city} ${" / "} ${res.county} ${" / "}     ${res.neighborhood}</span>
                                        </div>
                                </div>
                                <hr>
                            `);
                            @endif
                        });
                    } else {
                        $('.pp-row').html(`
                        <div class="col-12 text-center my-4 p-3" style="font-size:12px">Sonuç bulunamadı.</div>
                        `);
                        $('.pp-col').html(`
                        <div class="col-12 text-center my-4 p-3" style="font-size:12px">Sonuç bulunamadı.</div>
                        `);
                    }
                }
            });
        }

        function redirectToReservation(resId) {
            window.location.href = '{{ route('housing.show', ['resIdPlaceholder']) }}'.replace('resIdPlaceholder', resId);
        }
        // Sıralama seçenekleri için

        function sortSelectFilters(val) {
            var selectedValue = val;
            var filters = {};

            switch (selectedValue) {
                case 'price-asc':
                    filters.sort = 'price-asc';
                    break;
                case 'price-desc':
                    filters.sort = 'price-desc';
                    break;
                case 'date-asc':
                    filters.sort = 'date-asc';
                    break;
                case 'date-desc':
                    filters.sort = 'date-desc';
                    break;
                default:
                    // Varsayılan sıralama seçeneği burada belirtilebilir.
                    break;
            }

            return filters.sort;
        }

        $(function() {
            drawList();

            function filterNow() {
                let room_count = [];
                $('#room_count_field .mb-2').each(function() {
                    let i = $(this).find('.form-check-input');
                    if (i.is(':checked')) {
                        room_count.push(i.attr('id').replace('_', '+'));
                    }
                });

                let post_date;
                $('#post_date_field .mb-2').each(function() {
                    let i = $(this).find('input[type=radio]');
                    if (i.is(':checked')) {
                        post_date = i.attr('id');
                        return false;
                    }
                });

                let from_owner;
                $('#from_owner_field .mb-2').each(function() {
                    let i = $(this).find('input[type=radio]');
                    if (i.is(':checked')) {
                        from_owner = i.attr('id');
                        return false;
                    }
                });
                var filterValues = {}
                @foreach ($filters as $filter)
                    @if ($filter['type'] == 'select' || $filter['type'] == 'checkbox-group')
                        var checkedValues = [];
                        $('input[name="{{ $filter['name'] }}[]').each(function() {
                            if ($(this).is(':checked')) {
                                checkedValues.push($(this).val());
                            }
                        });

                        filterValues["{{ $filter['name'] }}"] = checkedValues;
                    @else

                        @if ($filter['text_style'] == 'min-max')
                            filterValues["{{ $filter['name'] }}-min"] = $(
                                'input[name="{{ $filter['name'] }}-min"]').val().replace('.', "").replace('.',
                                "").replace('.', "").replace('.', "").replace('.', "").replace('.', "");
                            filterValues["{{ $filter['name'] }}-max"] = $(
                                "input[name='{{ $filter['name'] }}-max']").val().replace('.', "").replace('.',
                                "").replace('.', "").replace('.', "").replace('.', "").replace('.', "");
                        @else
                            filterValues["{{ $filter['name'] }}"] = $('input[name="{{ $filter['name'] }}"]')
                                .val();
                        @endif
                    @endif
                @endforeach
                drawList({
                    page: current_page,
                    city: $('#city').val(),
                    county: $('#county').val(),
                    project_type: $("#project_type").val(),
                    neighborhood: $('#neighborhood').val(),
                    filterDate: $(".filter-date:checked").val(),
                    zoning: $("#zoning").val(),
                    sort: sortSelectFilters($('#sort-select').val()),
                    ...filterValues
                });
            }

            $('#sort-select').on('change', filterNow);
            $("#submit-filters").on("change", filterNow);

            $('#clear-filters').on('click', function() {
                $('#city').val('#');
                $('#county').val('#');
                $('#project_type').val('#');
                $('input[type=radio]').prop('checked', false);
                $('.form-check-input').prop('checked', false);

                @if ($secondhandHousings)
                    $('#price-min').val('');
                    $('#price-max').val('');
                    $('#msq-min').val('');
                    $('#msq-max').val('');
                    $('.bathroom-count-item').removeClass('bg-dark').removeClass('text-white');
                    bathroom_count = null;


                    $('#room_count_field .mt-4 .mb-2').each(function() {
                        let i = $(this).find('.form-check-input');
                        i.prop('checked', false);
                    });

                    $('#post_date_field .mb-2').each(function() {
                        let i = $(this).find('input[type=radio]');
                        i.prop('checked', false);
                    });

                    $('#from_owner_field .mb-2').each(function() {
                        let i = $(this).find('input[type=radio]');
                        i.prop('checked', false);
                    });
                @endif

                drawList();
            });

            $('body').on('click', '.filter-page', function() {
                current_page = $(this).data('page');

                filterNow();
            });

            $('body').on('click', '.next-page', function() {
                ++current_page;

                filterNow();
            });

            $('body').on('click', '.prev-page', function() {
                --current_page;

                filterNow();
            });

            $('.filter-now').on('change', filterNow);
            $('.bathroom-count-item').on('click', filterNow);
        });


        checkFavorites();

        function checkFavorites() {
            var favoriteButtons = document.querySelectorAll(".toggle-favorite");

            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-housing-id");
                
                $.ajax({
                    url: "{{ route('get.housing.favorite.status', ['id' => ':id']) }}"
                        .replace(':id', housingId),
                    type: "GET",
                    success: function(response) {
                        if (response.is_favorite) {
                            button.querySelector("i").classList.remove(
                                "fa-heart-o");
                            button.querySelector("i").classList.add(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "text-danger");
                            button.classList.add("bg-white");
                        } else {
                            button.querySelector("i").classList.remove(
                                "text-danger");
                            button.querySelector("i").classList.remove(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "fa-heart-o");
                        }
                    },
                    error: function(error) {
                        button.querySelector("i").classList.remove(
                            "text-danger");
                        button.querySelector("i").classList.remove(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "fa-heart-o");
                        console.error(error);
                    }
                });
            });
        }
    </script>
@endsection


@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #submit-filters {
            border: 1px solid #CCC;
            font-size: 12px;
            position: fixed;
            bottom: 10px;
            width: 255px;
            background: #EA2B2E !important;
            color: white;
            z-index: 9999;
            transition: position 0.3s ease;
            /* Animasyon eklemek için geçiş efekti */
        }

        #submit-filters.scroll-up {
            position: inherit !important;
        }

        .projectMobileMargin {
            margin-top: 20px;
        }

        #pages {
            position: absolute;
            width: 100%;
            bottom: 0;
            justify-content: center
        }

        hr {
            width: 100%;
            height: 100%;
        }

        .homes-content h4 {
            height: 30px !important;
        }

        .brand-head .brand-name {
            margin-left: 0 !important;
            margin-right: 10px !important
        }

        .brand-head .brands-square {
            padding-left: 0 !important
        }


        .btn-white {
            background: #fff !important;
            border: 0.0625rem solid rgba(33, 50, 91, .1);
        }

        .btn-transition {
            transition: all .2s ease-in-out
        }

        .text-primary {
            color: #274abb !important;
        }

        .btn-transition:focus,
        .btn-transition:hover {
            transform: translateY(-0.1875rem);
        }

        .btn-check:focus+.btn-white,
        .btn-white:focus,
        .btn-white:hover {
            color: #1366ff;
            border-color: rgba(33, 50, 91, .1);
            background-color: #fff;
            box-shadow: 0 3px 6px -2px rgba(140, 152, 164, .25)
        }

        .filter-now {
            display: block;
            width: 100%;
        }

        .widget-boxed {
            padding: 20px;
        }

        @media (max-width:768px) {

            .mobile-title {
                margin: 0 !important;
                padding: 0 !important;
            }

            .room_count_field {
                padding: 9px
            }

            .mobile-title {
                padding-bottom: 10px;
                padding-top: 10px;

                margin-bottom: 10px;

            }

            #sort-select {
                margin: 15px 0;
                width: 200px;
            }

            .circleIcon {
                font-size: 5px;
                color: #e54242 !important;
                padding-right: 5px
            }

            section.headings-2 {

                padding: 0 !important
            }

            .car {
                display: none;
            }

            .priceFont {
                font-weight: 600;
                font-size: 12px;
            }
        }

        .head {
            cursor: pointer;
            align-items: center
        }

        .trip-search {
            border: 1px solid #eaeff5;
            padding: 9px
        }
    </style>
@endsection
