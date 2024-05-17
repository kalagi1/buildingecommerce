@extends('client.layouts.master')

@section('content')
    <style>
        /* css */
        .trip-search select {
            border: 1px solid #eee;
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
                width: 90%;
                margin: 0 auto;
                font-size: 9px !important;
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
                font-size: 9px;
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
                            <div class="d-md-none" style="margin: 0 auto;  color: #FFF;">FİLTRELE</div>
                            <!-- Search Fields -->
                        </div>

                        <div>

                            <div class="mobile-filters">
                                <a id="clear-filters"
                                    style="font-size: 9px;text-decoration: underline !important;color: black;cursor: pointer;margin-bottom: 10px;text-align: left;width: 100%;display: block;">Temizle</a>
                                @if (isset($items) && count($items) > 0)
                                    <div class="trip-search itemsDiv">
                                        <div class="recent-post">
                                            @if ($slugName)
                                                @if ($slugName == 'Topraktan Projeler' || $slugName == 'Devam Eden Projeler' || $slugName == 'Tamamlanan Projeler')
                                                    <h3 style="padding: 0.5rem 0; margin-bottom:0">
                                                        <a href="{{ url('/kategori/tum-projeler') }}" style="color: #444"><i
                                                                class="fa fa-caret-right" style="margin-right: 1rem;"
                                                                aria-hidden="true"></i>Tüm
                                                            Projeler</a>
                                                    </h3>
                                                    <h3 style="padding: 0.5rem 0; margin-bottom:0; margin-left:10px">
                                                        <a href="{{ url('/kategori/' . $slugItem) }}" style="color: #444">
                                                            <i class="fa fa-caret-right" style="margin-right: 1rem;"
                                                                aria-hidden="true"></i>{{ $slugName }} </a>
                                                    </h3>
                                                @else
                                                    <h3 style="padding: 0.5rem 0; margin-bottom:0">
                                                        <a href="{{ url('/kategori/' . $slugItem) }}" style="color: #444"><i
                                                                class="fa fa-caret-right" style="margin-right: 1rem;"
                                                                aria-hidden="true"></i>{{ $slugName }}</a>
                                                    </h3>
                                                @endif
                                            @endif
                                            @if ($housingTypeParentSlug)
                                                <h3
                                                    style=" @if (
                                                        $slugName == 'Topraktan Projeler' ||
                                                            $slugName == 'Al Sat Acil' ||
                                                            ($slugName == 'Devam Eden Projeler' || $slugName == 'Tamamlanan Projeler')) margin-left: 20px;padding:0 !important; margin-bottom: 0 !important @else margin-bottom:0; @endif  ">
                                                    <a href="{{ url('/kategori/' . ($slugItem ? $slugItem . '/' : '') . $housingTypeParentSlug) }}"
                                                        style="color: #444">
                                                        <i class="fa fa-caret-right"
                                                            style="padding: 0.5rem 0; margin-right: 1rem;"
                                                            aria-hidden="true"></i>
                                                        {{ $housingTypeSlugName }}
                                                    </a>
                                                </h3>
                                            @endif

                                            @if ($slugItem == 'tum-projeler')
                                                <ul style="margin-left: 20px" class="item_submenu">
                                                    <li style="padding: 0 !important;">
                                                        <a href="/kategori/topraktan-projeler">
                                                            <i class="fa fa-caret-right" aria-hidden="true"
                                                                style="padding: 0.5rem 0;"></i>Topraktan
                                                            Projeler
                                                        </a>
                                                    </li>
                                                    <li style="padding: 0 !important;">
                                                        <a href="/kategori/devam-eden-projeler">
                                                            <i class="fa fa-caret-right" aria-hidden="true"
                                                                style="padding: 0.5rem 0;"></i>Devam Eden
                                                            Projeler
                                                        </a>
                                                    </li>
                                                    <li style="padding: 0 !important;">
                                                        <a href="/kategori/tamamlanan-projeler">
                                                            <i class="fa fa-caret-right" aria-hidden="true"
                                                                style="padding: 0.5rem 0;"></i>Tamamlanan
                                                            Projeler
                                                        </a>
                                                    </li>
                                                </ul>
                                            @else
                                                <ul>
                                                    @foreach ($items as $key => $item)
                                                        @php
                                                            $itemSlug = url(
                                                                '/kategori/' .
                                                                    ($slugItem ? $slugItem . '/' : '') .
                                                                    ($housingTypeParentSlug
                                                                        ? $housingTypeParentSlug . '/'
                                                                        : '') .
                                                                    $item->slug,
                                                            );
                                                        @endphp
                                                        <li @if ($optName && $optName == $item->title) class="d-show"
                                                    @elseif($optName && $optName != $item->title)
                                                        class="d-none" @endif
                                                            style="padding: 0 !important;
                                                             @if (
                                                                 $housingTypeParentSlug ||
                                                                     $slugName == 'Topraktan Projeler' ||
                                                                     $slugName == 'Al Sat Acil' ||
                                                                     ($slugName == 'Devam Eden Projeler' || $slugName == 'Tamamlanan Projeler' || $slugName == 'Emlak İlanları')) margin-left: 20px; @endif
                                                                @if (
                                                                    ($slugName == 'Topraktan Projeler' && $housingTypeParentSlug) ||
                                                                        ($slugName == 'Al Sat Acil' && $housingTypeParentSlug) ||
                                                                        ($slugName == 'Devam Eden Projeler' && $housingTypeParentSlug) ||
                                                                        ($slugName == 'Tamamlanan Projeler' && $housingTypeParentSlug)) margin-left: 30px @endif">

                                                            <a href="{{ $itemSlug }}">
                                                                <i class="fa fa-caret-right" style="padding: 0.5rem 0;"
                                                                    aria-hidden="true"></i>{{ $item->title }}
                                                            </a>

                                                            @if ($housingTypeParentSlug)
                                                                @include(
                                                                    'client.layouts.partials.submenu',
                                                                    [
                                                                        'parents' => $item->parents,
                                                                        'connections' => $item->connections,
                                                                    ]
                                                                )
                                                            @endif

                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif

                                        </div>
                                    </div>
                                @endif



                                <div class="trip-search  @if (isset($items)) mt-3 @endif">
                                    <div class="widget-boxed-header mobile-title widget-boxed-header">
                                        <span>Adres</span>
                                    </div>
                                    <div class="mt-md-2">
                                        <select id="city" class="bg-white filter-now mobile-button">
                                            <option value="#" class="selected" selected disabled>İl</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ $city['id'] }}" data-city="{{ $city['title'] }}">
                                                    {{ $city['title'] }}</option>
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

                                <div id="room_count_field" class="room_count_field">
                                    <div class="trip-search mt-md-2">
                                        <div class="head widget-boxed-header mobile-title widget-boxed-header"
                                            onclick="toggleFilter(this)">

                                            <span>
                                                İlan Tarihi
                                            </span>
                                        </div>
                                        <div class="mt-md-2 filtreArea" style="display: none !important">
                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio" name="listing_date"
                                                    id="last_24_hours" value="24">
                                                <label class="form-check-label w-100 ml-4" for="last_24_hours">Son 24
                                                    Saat</label>
                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio" name="listing_date"
                                                    id="last_3_days" value="3">
                                                <label class="form-check-label w-100 ml-4" for="last_3_days">Son 3
                                                    Gün</label>
                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio" name="listing_date"
                                                    id="last_7_days" value="7">
                                                <label class="form-check-label w-100 ml-4" for="last_7_days">Son 7
                                                    Gün</label>
                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio" name="listing_date"
                                                    id="last_15_days" value="15">
                                                <label class="form-check-label w-100 ml-4" for="last_15_days">Son 15
                                                    Gün</label>
                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio" name="listing_date"
                                                    id="last_30_days" value="30">
                                                <label class="form-check-label w-100 ml-4" for="last_30_days">Son 30
                                                    Gün</label>
                                            </div>


                                        </div>
                                    </div>
                                </div>


                                <div id="room_count_field" class="room_count_field">
                                    <div class="trip-search mt-md-2">
                                        <div class="head widget-boxed-header mobile-title widget-boxed-header"
                                            onclick="toggleFilter(this)">
                                            <span>
                                                Kimden
                                            </span>
                                        </div>
                                        <div class="mt-md-2 filtreArea" style="display: none !important">
                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio"
                                                    name="corporate_type" id="EmlakOfisi" value="Emlak Ofisi">
                                                <label class="form-check-label w-100 ml-4" for="EmlakOfisi">Emlak
                                                    Ofisinden
                                                </label>
                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio"
                                                    name="corporate_type" id="İnsaatOfisi" value="İnşaat Ofisi">
                                                <label class="form-check-label w-100 ml-4" for="İnsaatOfisi">İnşaat
                                                    Ofisinden
                                                </label>
                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio"
                                                    name="corporate_type" id="banka" value="Banka">
                                                <label class="form-check-label w-100 ml-4" for="banka">Bankadan</label>

                                            </div>

                                            <div class="mb-2 d-flex align-items-center">
                                                <input class="filter-now form-control" type="radio"
                                                    name="corporate_type" id="TurizmAmaçliKiralama"
                                                    value="Turizm Amaçlı Kiralama">
                                                <label class="form-check-label w-100 ml-4"
                                                    for="TurizmAmaçliKiralama">Turizm İşletmesinden
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                @foreach ($filters as $filter)
                                    @if ($filter['type'] != 'text')
                                        <div id="room_count_field" class="room_count_field ">
                                            <div class="trip-search mt-md-2">
                                                <div class="head widget-boxed-header mobile-title widget-boxed-header"
                                                    onclick="toggleFilter(this)">
                                                    <span>
                                                        @if ($filter['label'] == 'Peşin Fiyat')
                                                            Fiyat
                                                        @else
                                                            {{ $filter['label'] }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="mt-md-2 filtreArea"
                                                    @if ($filter['label'] == 'Peşin Fiyat' || $filter['label'] == 'Fiyat') style="display: flex !important;"
                                                    @else
                                                    style="display: none !important;" @endif>
                                                    @if (isset($filter['values']))
                                                        @foreach ($filter['values'] as $key => $value)
                                                            @if (isset($filter['toggle']) && $filter['toggle'] == true)
                                                                <!-- Switch-slider öğesi -->

                                                                <div class="mb-2 d-flex align-items-center">
                                                                    <label class="switch-slider">
                                                                        <input name="{{ $filter['name'] }}[]"
                                                                            type="checkbox" value="{{ $value->value }}"
                                                                            class="filter-now form-control switch"
                                                                            id="{{ $filter['name'] . $key }}">
                                                                        <span class="slider"></span>
                                                                    </label>
                                                                    <label for="{{ $filter['name'] . $key }}"
                                                                        class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                                                                </div>
                                                            @else
                                                                @if ($filter['type'] == 'select')
                                                                    @if ($key != 0)
                                                                        <div class="mb-2 d-flex align-items-center">
                                                                            <input name="{{ $filter['name'] }}[]"
                                                                                type="checkbox"
                                                                                value="{{ $value->value }}"
                                                                                class="filter-now form-control"
                                                                                id="{{ $filter['name'] . $key }}">
                                                                            <label for="{{ $filter['name'] . $key }}"
                                                                                class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                                                                        </div>
                                                                    @endif
                                                                @elseif($filter['type'] == 'checkbox-group')
                                                                    <div class="mb-2 d-flex align-items-center">
                                                                        <input name="{{ $filter['name'] }}[]"
                                                                            type="checkbox" value="{{ $value->value }}"
                                                                            class="filter-now form-control"
                                                                            id="{{ $filter['name'] . $key }}">
                                                                        <label for="{{ $filter['name'] . $key }}"
                                                                            class="form-check-label w-100 ml-4">{{ $value->label }}</label>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($filter['type'] == 'text')
                                        <div id="room_count_field"class="room_count_field ">
                                            <div class="trip-search mt-md-2">
                                                <div class="widget-boxed-header mobile-title widget-boxed-header"
                                                    onclick="toggleFilterDiv(this)">
                                                    <span>
                                                        @if ($filter['label'] == 'Peşin Fiyat')
                                                            Fiyat
                                                        @else
                                                            {{ $filter['label'] }}
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="d-flex align-items-center mt-md-2"
                                                    @if ($filter['label'] == 'Peşin Fiyat' || $filter['label'] == 'Fiyat') style="display: flex !important;"
                                                    @else
                                                    style="display: none !important;" @endif>
                                                    @if ($filter['text_style'] == 'min-max')
                                                        <span id="slider-range-value1">
                                                            <input type="text"
                                                                name="{{ str_replace('[]', '', $filter['name']) }}-min"
                                                                id="{{ str_replace('[]', '', $filter['name']) }}-min"
                                                                min="0" placeholder="En Düşük"
                                                                class="filter-now form-control price-only">
                                                        </span>
                                                        <i class="fa fa-solid fa-minus mx-2 dark-color icon"></i>
                                                        <span id="slider-range-value2">
                                                            <input type="text"
                                                                id="{{ str_replace('[]', '', $filter['name']) }}-max"
                                                                min="0" placeholder="En Yüksek"
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
                                    <script>
                                        function toggleFilterDiv(element) {
                                            var filterContent = $(element).parent().find('.mt-md-2');
                                            var filterIcon = $(element).parent().find('#filter-icon');

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
                                @endforeach


                            </div>

                            <button type="button" class="btn bg-white btn-lg btn-block mt-md-2 mb-4e btn-transition"
                                style="    border: 1px solid #CCC;
                            font-size: 9px;
                            position: fixed;
                            bottom: 10px;
                            width: 255px;
                            background: #EA2B2E !important;
                            color: white;
                            z-index:9999"
                                id="submit-filters" onclick="$('.filters-input-area').slideToggle();">Filtrele</button>

                            <button type="button" onclick="$('.filters-input-area').slideToggle();"
                                class="d-md-none  d-lg-none btn bg-white btn-lg btn-block mt-md-2 mb-4e btn-transition"
                                style="border: 1px solid #CCC;" id="clear-filters">Kapat</button>



                        </div>

                    </div>
                </aside>

                <div class="col-lg-9 col-md-12 blog-pots order-1">
                    <section class="headings-2 pt-0 d-md-flex" style="display: grid;">
                        <div class="brand-head py-2" style="padding-top: 0">

                            <span class="d-none" id="termResultCount">
                                <span id="searchResultsText"> </span>
                            </span><br>

                            <div class="brands-square" style="position: relative; top: 0; left: 0">

                                @if ($slugName)
                                    <p class="brand-name" style="color: black">{{ $slugName }}</p>
                                @endif
                                @if ($housingTypeSlugName)
                                    @if ($slugName)
                                        <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    @endif
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
                                <div class="hiddenCityName d-none">
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name cityNameP" style="color: black"></p>
                                </div>
                                <div class="hiddenCountyName d-none">
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name countyNameP" style="color: black"></p>
                                </div>
                                <div class="hiddenNeighborhoodName d-none">
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name countyNameP" style="color: black"></p>
                                </div>
                                {{-- @if ($checkTitle)
                                    <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i></p>
                                    <p class="brand-name" style="color: black">
                                        {{ ucwords(str_replace('-', ' ', $checkTitle)) }}</p>
                                @endif --}}

                            </div>
                        </div>
                        <div id="sorting-options" class="d-flex align-items-center ml-0 ml-md-auto mr-md-0">
                            @if ($secondhandHousings)
                                <div class="mobile-hidden">
                                    <a href="#" id="grid-view-btn" class="change-view-btn active-view-btn"
                                        onclick="changeView('grid')">
                                        <i class="fa fa-th-large"></i>
                                    </a>
                                    <a href="#" id="list-view-btn" class="change-view-btn lde mr-3"
                                        onclick="changeView('list')">
                                        <i class="fa fa-th-list"></i>
                                    </a>

                                </div>
                            @endif
                            <div onclick="$('.filters-input-area').slideToggle();" class="d-lg-none"
                                style="    background: #f0f0f0 !important;
                              padding: 6px;
                              cursor: pointer;
                              width: 50%;
                              text-align: center;
                              color: black;
                              height: 35px !important;">
                                <span>Filtrele</span>
                            </div>
                            <select id="sort-select" class="form-control">
                                <option value="sort">Sırala</option>
                                @if ($secondhandHousings)
                                    <option value="price-asc">Fiyata göre (Önce en düşük)</option>
                                    <option value="price-desc">Fiyata göre (Önce en yüksek)</option>
                                @endif

                                <option value="date-asc">Tarihe göre (Önce en eski ilan)</option>
                                <option value="date-desc">Tarihe göre (Önce en yeni ilan)</option>
                            </select>



                        </div>


                    </section>
                    <section class="popular-places home18 mt-3" style="padding-top:0 !important">
                        <div class="container">
                            <div class="mobile-hidden">
                                <div class="row pp-row">
                                </div>
                                <div class="pp-row-list">
                                </div>
                            </div>
                            <div class="mobile-show">
                                <div class="row pp-col homepage-9">
                                </div>
                            </div>

                        </div>
                    </section>
                    <div id="pages" class="d-flex justify-content-center" style="gap: 12px;">
                    </div>

                </div>

            </div>

        </div>
    </section>

@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // Görünüm değiştirme düğmeleri için işlev
        function changeView(view) {
            // Aktif görünüm düğmesinin rengini güncelle
            $(".change-view-btn").removeClass("active-view-btn");
            $("#" + view + "-view-btn").addClass("active-view-btn");

            // Görünümü değiştir
            if (view === "grid") {
                $(".pp-row").show();
                $(".pp-row-list").hide();
            } else if (view === "list") {
                $(".pp-row").hide();
                $(".pp-row-list").show();
            }
        }

        // Sayfa yüklendiğinde varsayılan olarak grid görünümünü seç
        $(document).ready(function() {
            changeView("grid");
        });
    </script>

    <script>
        $(document).ready(function() {

            $("#clear-filters").click(function() {
                $("#city").val("#").trigger('change'); // İl seçeneğini sıfırla
                $("#county").val("#").trigger('change'); // İlçe seçeneğini sıfırla
                $("#neighborhood").val("#").trigger('change'); // Mahalle seçeneğini sıfırla
                $("input[type='checkbox']").prop('checked', false);
                $("input").val("");
                $(".hiddenCountyName").removeClass("d-flex").addClass("d-none");
                $(".hiddenNeighborhoodName").removeClass("d-flex").addClass("d-none");
                $(".hiddenCityName").removeClass("d-flex").addClass("d-none");


            });
        });

        $(document).ready(function() {
            $('#city').select2({
                placeholder: 'İl',
                width: '100%',
                searchInputPlaceholder: 'Ara...',

            });
            $("#project_type").select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
            $('#county').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });
            $('#neighborhood').select2({
                minimumResultsForSearch: -1,
                width: '100%',
            });

        });
    </script>
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
            if ($(this).val().replace('.', '').replace('.', '').replace('.', '').replace('.', '') !=
                parseInt($(this).val().replace('.', '').replace('.', '').replace('.', '').replace('.', '')
                    .replace('.', ''))) {
                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                    $(this).val("");
                } else {
                    $(this).closest('.form-group').append(
                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $(this).val("");
                }

            } else {
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
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
                    $(".hiddenCountyName").removeClass("d-flex").addClass("d-none");
                    $(".hiddenNeighborhoodName").removeClass("d-flex").addClass("d-none");
                    $(".hiddenCityName").removeClass("d-none").addClass("d-flex").children(".cityNameP")
                        .html(res.cityName);
                    res.counties.forEach((e) => {
                        $('#county').append(
                            `<option value="${e.ilce_key}">${e.ilce_title}</option>`
                        );
                        $('#county').val('#');
                    });
                    $('#county').select2({
                        placeholder: 'İlçe',
                        width: '100%',
                        searchInputPlaceholder: 'Ara...'
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
                    $(".hiddenCountyName").removeClass("d-none").addClass("d-flex").children(
                        ".countyNameP").html(res.countyName);
                    $(".hiddenNeighborhoodName").removeClass("d-flex").addClass("d-none");

                    $('#neighborhood').append('<option value="#" disabled>Mahalle</option>');
                    res.neighborhoods.forEach((e) => {
                        $('#neighborhood').append(
                            `<option value="${e.mahalle_id}">${e.mahalle_title}</option>`
                        );
                        $('#neighborhood').val('#');
                    });
                    $('#neighborhood').select2({
                        placeholder: 'Mahalle',
                        width: '100%',
                        searchInputPlaceholder: 'Ara...'
                    });


                }
            });
        });

        $('#neighborhood').on('change', function() {
            $.ajax({
                method: "GET",
                url: "{{ url('get-neighborhood') }}/" + $(this).val(),
                success: function(res) {
                    $(".hiddenNeighborhoodName").removeClass("d-none").addClass("d-flex").children(
                        ".countyNameP").html(res.neighborhoodName);

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
            var cityID = @json($cityID ?? null);

            var term = @json($term ?? null);

            var data = Object.assign({}, filters, {
                _token: "{{ csrf_token() }}",
                slug: slug,
                type: type,
                title: title,
                optional: optional,
                checkTitle: checkTitle,
                term: term,
                cityID: cityID

            });


            let currentData = {};




            Object.keys(data).map(e => {
                if (data[e])
                    currentData[e] = data[e];
            });

            console.log(currentData);

            $.ajax({
                method: "POST",
                url: "{{ route($secondhandHousings ? 'get-rendered-secondhandhousings' : 'get-rendered-projects') }}",
                data: currentData,
                success: function(response) {
                    $('.pp-row').empty();
                    $('.pp-row-list').empty();
                    $('.pp-col').empty();
                    $('#pages').empty();

                    last_page = response.data.last_page;

                    $('#pages').append(`
                        <a class="btn btn-primary prev-page">Önceki</a>
                    `);

                    for (var i = 1; i <= response.data.last_page; ++i) {
                        $('#pages').append(`
                            <a class="btn btn-outline-primary filter-page" data-page="${i}" ${response.data.current_page == i ? 'style="color: white;background:#007bff"' : 'style="background: transparent;"'}>${i}</a>
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

                    if (response.data.data.length > 0) {

                        var term = response.term;
                        var count = response.totalCount;


                        if (count > 0 && term != null) {
                            $(".countArray").html('<span style="color: #EA2B2E; font-size: 13px;">' + count +
                                '</span>');
                            $("#termResultCount").removeClass("d-none").addClass("d-block");

                            var searchResultsText = '<span style="font-weight: bold;">"' + term + '"</span>' +
                                " araması için " + "<span> toplam " +
                                '<span style="color: #EA2B2E; font-size: 13px;">' + count +
                                '</span> sonuç bulundu.</span>';

                            $("#searchResultsText").html(searchResultsText);


                        }

                        var assetPath = "{{ asset('images/sc.png') }}";

                        response.data.data.forEach((res) => {
                            if (typeof res === "boolean")
                                return true;

                            const randomColor =
                                `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.8)`;

                            @if (!$secondhandHousings)
                                $('.pp-row').append(
                                    `
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-12 projectMobileMargin" data-aos="zoom-in" data-aos-delay="150" style="height:200px">
                                        <div class="project-single no-mb aos-init aos-animate" style="height:100%" data-aos="zoom-in" data-aos-delay="150">
                                            <div class="listing-item compact" style="height:100%">
                                                <a href="${res.url}" class="listing-img-container">
                                                    <span class="project_brand_profile_image">
                                                        <img src="${res.profile_user_image}" alt="">
                                                        <span class="country">${res.city.title} / ${res.county.ilce_title}</span>
                                                    </span>

                                                    
                                                    <div class="listing-img-content" style="padding-left:10px;text-transform:uppercase;background-color: ${randomColor};">
                                                        <span class="badge badge-phoenix text-left">${res.title} </span>
                                                
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
                                                <a href="${res.url}" class="listing-img-container">
                                                    <span class="project_brand_profile_image">
                                                            <img src="${res.profile_user_image}" alt="">
                                                            <span class="country">${res.city.title} / ${res.county.ilce_title}</span>
                                                        </span>

                                                    
                                                    <div class="listing-img-content" style="padding-left:10px;text-transform:uppercase;background-color: ${randomColor};">
                                                        <span class="badge badge-phoenix text-left">${res.title} </span>
                                                
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
                                    featuredHtml =
                                        '<div class="homes-tag button alt featured">Sponsorlu</div>';
                                } else {
                                    var total = res.id + 2000000;
                                    featuredHtml =
                                        '<div class="homes-tag button alt featured" style="width:90px !important">No: ' +
                                        total + '</div>';
                                }

                                function kisalt(text, uzunluk) {
                                    if (typeof text == "string" && text.length > uzunluk) {
                                        return text.substring(0, uzunluk - 3) + "...";
                                    }
                                    return text;
                                }

                                var showAddCollectionButton =
                                    "{{ Auth::check() ? Auth::user()->type : '' }}";


                                // Metni kırp ve üç nokta ekle
                                var kisaltilmisBaslik = kisalt(res.title, 45);

                                // Tarihi almak için bir fonksiyon
                                function formatDate(dateString) {
                                    var options = {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    };
                                    var date = new Date(dateString);
                                    return date.toLocaleDateString('tr-TR',
                                        options); // 'tr-TR' Türkçe tarih formatını temsil eder
                                }

                                // Tarih verisini al
                                var tarih = formatDate(res.created_at);
                                const isAvailable = res.housing_type.open_share1 == true;

                                // Class assignment with nested conditions
                                const spanClass = isAvailable ?
                                    (res.action !== 'sold' || res.offSale ?
                                        'btn addCollection' :
                                        'btn disabledShareButton') :
                                    'btn hidden'; // Hide if open_share1 does not exist

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
                                                        <div class="button-effect-div">
                                                            ` + `
<span class="${spanClass}" data-type="housing" data-id="${res.id}">
    <i class="fa fa-bookmark-o"></i>
</span>  ` +
                                    ` 
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
                                                                <i class="fa fa-map-marker pr-2"></i><span>${res.city} ${" / "} ${res.county} ${" / "} ${res.neighborhood} </span>
                                                            </a>
                                                        </p>
                                                        <ul class="homes-list clearfix pb-3" style="display: flex; justify-content: space-evenly;align-items: center;width: 100%;">
                                                            ${res.column1 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column1)} ${res.column1_additional ? res.column1_additional : " "}</span></li>` : ''}
                                                            ${res.column2 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column2)} ${res.column2_additional ? res.column2_additional : " "}</span></li>` : ''}
                                                            ${res.column3 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column3)} ${res.column3_additional ? res.column3_additional : " "}</span></li>` : ''}
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-4" style="display: flex; justify-content: space-between;margin-top:20px !important">
                                                            <li style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap" class="priceFont">
                                                                ${res.step2_slug !== "gunluk-kiralik" ?
                                                                    res.offSale || (res.action === 'payment_await' || res.action === 'sold') ? " "
                                                                    : numberFormat(res.housing_type.price) + " ₺"
                                                                    : numberFormat(res.housing_type.daily_rent) + " ₺" + " <span  style='font-size:12px; color:#EA2B2E !important' class='mobilePriceStyle'>1 Gece</span>"
                                                                }
                                                            </li>
                                                            <li style="display: flex; justify-content: right;width:100%">
                                                                ${tarih}
                                                            </li>
                                                        </ul>
                                                        <ul class="homes-list clearfix pb-3" style="display: flex; justify-content: center;">
                                                            ${res.step2_slug !== "gunluk-kiralik" ?
                                                                res.offSale ?
                                                                    `<button class="btn second-btn " style="background: #EA2B2E !important;width:100%;color:White">Satışa Kapatıldı</button>`
                                                                    :
                                                                    res.action === 'payment_await' ?
                                                                        `<button class="btn second-btn " style="background: orange !important;width:100%;color:White;">Rezerve Edildi</button>`
                                                                        :
                                                                        res.action === 'sold' ?
                                                                            `<button class="btn second-btn " style="width: 100%; border: none; background:#EA2B2E !important; border-radius: 10px; padding: 5px 0px; color: white">Satıldı</button>`
                                                                            :
                                                                            `<button class="CartBtn ${res.in_cart ? 'bg-success text-white' : ''}" data-type='housing' data-id='${res.id}'>
                                                                                                                                                                                <span class="IconContainer">
                                                                                                                                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                                                                                                                                </span>
                                                                                                                                                                                <span class="text text-white">${res.in_cart ? 'Sepete Eklendi' : 'Sepete Ekle'}</span>
                                                                                                                                                                            </button>` :
                                                                `<button onclick="redirectToReservation('${res.id}','${res.slug}')" class="reservationBtn">
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
                                `);


                                $('.pp-row-list').append(`

                                    <div class="row border-row">
                                        <div class="item col-lg-3 col-md-12 col-xs-12 landscapes sale pr-0 pl-0 pb-0">
                                            <div class="mb-0 bb-0 aos-init aos-animate" data-aos="fade-up">
                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                                        <!-- homes img -->
                                                                        <div class="homes-img">
                                                                            ${featuredHtml}
                                                                            <img src="${res.image}" alt="${res.housing_type_title}" class="img-responsive" style="height: 110px !important;">
                                                                        </div>
                                                                    </div>
                                                                    <div class="button-effect-div">
                                                                    
                                                                        ` + `
<span class="${spanClass}" data-type="housing" data-id="${res.id}">
    <i class="fa fa-bookmark-o"></i>
</span>  ` +
                                    ` 
                                                            <div href="" class="btn toggle-favorite bg-white ${res.in_favorites ? 'bg-white' : ''}" data-housing-id="${res.id}">
                                                                <i class="fa fa-heart-o ${res.in_favorites ? 'text-danger' : ''}"></i>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- homes content -->
                                        <div class="col-lg-9 col-md-12 homes-content pb-0 mb-44 aos-init aos-animate" data-aos="fade-up" style="padding:10px 20px !important">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">     <!-- homes address -->
                                            <a href="${res.housing_url}" style="color:black" class="mt-3">
                                                                        <span>${res.title}</span>
                                                                    </a>
                                            <p class="homes-address mb-3">
                                                                            <i class="fa fa-map-marker pr-2"></i><span>${res.city} ${" / "} ${res.county} ${" / "} ${res.neighborhood} </span>
                                                                    
                                            </p>
                                            <!-- homes List -->
                                            <ul class="homes-list clearfix pb-3" style="display: flex; justify-content: space-between;align-items: center;width: 100%;">
                                                                        ${res.column1 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column1)} ${res.column1_additional ? res.column1_additional : " "}</span></li>` : ''}
                                                                        ${res.column2 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column2)} ${res.column2_additional ? res.column2_additional : " "}</span></li>` : ''}
                                                                        ${res.column3 ? `<li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span>${toTitleCase(res.column3)} ${res.column3_additional ? res.column3_additional : " "}</span></li>` : ''}
                                                                        <li class="d-flex align-items-center itemCircleFont" style='width:auto !important'><i class='fa fa-circle circleIcon mr-1'></i><span> ${tarih}</span></li>
                                                                                                                                </ul>
                                                                                                                                </div>

                                                                                                                                <div class="col-md-4">
                                                                                                                                    <ul class="homes-list clearfix pb-4" style="display: flex; justify-content: space-between;text-align:center">
                                                                        <li style="font-size: 16px; font-weight: 700;width:100%; white-space:nowrap" class="priceFont">
                                                                            ${res.step2_slug !== "gunluk-kiralik" ?
                                                                                res.offSale || (res.action === 'payment_await' || res.action === 'sold') ? " "
                                                                                : numberFormat(res.housing_type.price) + " ₺"
                                                                                : numberFormat(res.housing_type.daily_rent) + " ₺" + " <span  style='font-size:12px; color:#EA2B2E !important' class='mobilePriceStyle'>1 Gece</span>"
                                                                            }
                                                                        </li>
                                                                    </ul>
                                                                    <ul class="homes-list clearfix" style="display: flex; justify-content: center;">
                                                                        ${res.step2_slug !== "gunluk-kiralik" ?
                                                                            res.offSale ?
                                                                                `<button class="btn second-btn " style="background: #EA2B2E !important;width:100%;color:White">Satışa Kapatıldı</button>`
                                                                                :
                                                                                res.action === 'payment_await' ?
                                                                                    `<button class="btn second-btn " style="background: orange !important;width:100%;color:White;">Rezerve Edildi</button>`
                                                                                    :
                                                                                    res.action === 'sold' ?
                                                                                        `<button class="btn second-btn " style="width: 100%; border: none; background:#EA2B2E !important; border-radius: 10px; padding: 5px 0px; color: white">Satıldı</button>`
                                                                                        :
                                                                                        `<button class="CartBtn ${res.in_cart ? 'bg-success text-white' : ''}" data-type='housing' data-id='${res.id}'>
                                                                                                                                                                                            <span class="IconContainer">
                                                                                                                                                                                                <img src="{{ asset('sc.png') }}" alt="">
                                                                                                                                                                                            </span>
                                                                                                                                                                                            <span class="text text-white">${res.in_cart ? 'Sepete Eklendi' : 'Sepete Ekle'}</span>
                                                                                                                                                                                        </button>` :
                                                                            `<button onclick="redirectToReservation('${res.id}','${res.slug}')" class="reservationBtn">
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
                                                                    ${res.housing_type.open_share1 ?
                                                                        ` <div class="homes-price"style="bottom: 0;left:0;z-index:9"><i class="fa fa-handshake-o"></i></div> `: " "
                                                                    }
                                                                    <img src="${res.image}" alt="${res.title}" class="img-responsive"
                                                                        style="height: 80px !important;">
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="w-100" style="padding-left:0;">
                                                    <div class="bg-white px-3 h-100 d-flex flex-column justify-content-center">
                                                        <a style="text-decoration: none;height:100%" href="${res.housing_url}">
                                                            <div class="d-flex"
                                                                style="gap: 8px;justify-content:space-between;align-items:center">
                                                                <h4  class="mobile-left-width">
                                                                ${res.title}
                                                            </h4>
                                                            <div class="mobile-right-width">
                                                                ` + `
<span class="${spanClass}" data-type="housing" data-id="${res.id}">
    <i class="fa fa-bookmark-o"></i>
</span>  ` +
                                    ` 
                                                            <span class="btn toggle-favorite bg-white" data-housing-id="${res.id}" style="color: white;">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </span>
                                                                </div>
                                                        
                                                                </div>
                                                        
                                                        </a>
                                                        <div class="d-flex" style="align-items:Center">
                                                            <div class="d-flex" style="gap: 8px;">
                                                            

                                                                                    ${res.step2_slug !== "gunluk-kiralik" ?
                                                                res.offSale ?
                                                                    `  <button class="btn second-btn  mobileCBtn" 
                                                                                                                                                                                                                                                                                                                                                                                                                                            style="background: #EA2B2E !important;width:100%;color:White">

                                                                                                                                                                                                                                                                                                                                                                                                                                            <span class="text">Satışa Kapatıldı</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                        </button>`
                                                                    :
                                                                    res.action === 'payment_await' ?
                                                                        `<button
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            class="btn mobileCBtn second-btn CartBtn" 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            style="background: orange !important;color:White">Rezerve Edildi
                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </button>`
                                                                        :
                                                                        res.action === 'sold' ?
                                                                            `<button
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="btn mobileCBtn second-btn CartBtn" 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                style="border: none; background:#EA2B2E !important; border-radius: 10px; padding: 5px 0px; color: white;">Satıldı
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>`
                                                                            :
                                                                            `<button class="CartBtn mobileCBtn ${res.in_cart ? 'bg-success text-white' : ''}" data-type='housing'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                data-id='${res.id}'>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="IconContainer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <img src="{{ asset('sc.png') }}" alt="">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="text text-white">${res.in_cart ? 'Sepete Eklendi' : 'Sepete Ekle'}</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </button>` :
                                                                                `<button onclick="redirectToReservation('${res.id}','${res.slug}')" class="reservationBtn mobileCBtn CartBtn">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <span class="IconContainer">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <img src="{{ asset('sc.png') }}" alt="">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <span class="text">Rezervasyon Yap</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </button>`
                                                                            }
                                                                                </div>
                                                                                <span class="ml-auto text-primary priceFont"
                                                                                style="text-align:right">
                                                                                    ${
                                                                    res.step2_slug !== "gunluk-kiralik"
                                                                    ? res.offSale || (res.action === 'payment_await' || res.action === 'sold')
                                                                        ? " "
                                                                        : numberFormat(res.housing_type.price) + " ₺"
                                                                    : numberFormat(res.housing_type.daily_rent) + " ₺" + " <span  style='font-size:12px; color:Red' class='mobilePriceStyle'>1 Gece</span>"
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
                                                    <span style="font-size: 9px !important">${res.city} ${" / "} ${res.county} </span>
                                                    </div>
                                            </div> <hr> `);
                            @endif
                        });
                    } else {
                        $('.pp-row').html(`
                        <div class="col-12 text-center my-4 p-3" style="font-size:12px">Sonuç bulunamadı.</div>
                        `);
                        $('.pp-row-list').html(`
                        <div class="col-12 text-center my-4 p-3" style="font-size:12px">Sonuç bulunamadı.</div>
                        `);
                        $('.pp-col').html(`
                        <div class="col-12 text-center my-4 p-3" style="font-size:12px">Sonuç bulunamadı.</div>
                        `);
                    }
                }
            });
        }

        function redirectToReservation(resId, resSlug) {
            // resId'yi bir tamsayıya dönüştür ve 1000000 ekleyerek topla
            var updatedResId = parseInt(resId) + 2000000;

            // Rotayı oluştur ve yer tutucuları değiştir
            var url =
                '{{ route('housing.show', ['housingSlug' => 'resSlugPlaceholder', 'housingID' => 'resIdPlaceholder']) }}';
            url = url.replace('resSlugPlaceholder', resSlug); // resSlugPlaceholder yerine resSlug değeriyle değiştir
            url = url.replace('resIdPlaceholder', updatedResId); // resIdPlaceholder yerine toplanmış değerle değiştir
            window.location.href = url; // Oluşturulan URL'ye yönlendir
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

                function getCheckedValues(selector) {
                    return $(selector + ':checked').map(function() {
                        return $(this).val();
                    }).get();
                }

                function getInputValue(selector) {
                    var input = $(selector);
                    return input.length ? input.val() : '';
                }

                var filterValues = {};

                @foreach ($filters as $filter)
                    @if ((isset($filter['type']) && $filter['type'] == 'select') || $filter['type'] == 'checkbox-group')
                        filterValues["{{ $filter['name'] }}"] = getCheckedValues(
                            'input[name="{{ $filter['name'] }}[]"]');
                    @else
                        @if (isset($filter['text_style']) && $filter['text_style'] == 'min-max')
                            filterValues["{{ $filter['name'] }}-min"] = getInputValue(
                                'input[name="{{ $filter['name'] }}-min"]').replace(/\./g, "");
                            filterValues["{{ $filter['name'] }}-max"] = getInputValue(
                                'input[name="{{ $filter['name'] }}-max"]').replace(/\./g, "");
                        @else
                            filterValues["{{ $filter['name'] }}"] = getInputValue(
                                'input[name="{{ $filter['name'] }}"]');
                        @endif
                    @endif
                @endforeach

                var listingDate = $("input[name='listing_date']:checked").val();
                var corporateType = $("input[name='corporate_type']:checked").val();
                console.log(listingDate);
                drawList({
                    page: current_page,
                    city: $('#city').val(),
                    county: $('#county').val(),
                    project_type: $("#project_type").val(),
                    neighborhood: $('#neighborhood').val(),
                    filterDate: $(".filter-date:checked").val(),
                    zoning: $("#zoning").val(),
                    sort: sortSelectFilters($('#sort-select').val()),
                    listing_date: listingDate,
                    corporateType: corporateType,
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
    </script>
@endsection


@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #submit-filters {
            border: 1px solid #CCC;
            font-size: 9px;
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
            width: 100%;
            justify-content: center
        }

        #pages .btn {
            height: 100% !important;
        }

        #pages .btn:hover {
            color: #007bff !important;
        }

        hr {
            width: 100%;
            height: 100%;
        }

        .homes-content h4 {
            height: 30px !important;
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


        #sort-select {
            height: 28.5px !important;
            padding: 0 !important;
            width: 120px
        }

        .pp-row-list .border-row {
            border: 1px solid #e7e7e7;
            margin-bottom: 10px
        }

        @media (max-width:768px) {
            .room_count_field {
                border-bottom: 1px solid #eaeff5;
            }

            .mobile-filters {
                padding: 10px
            }

            .mt-md-2 {
                margin-bottom: 10px
            }

            .trip-search {
                padding-top: 10px;
                margin-top: 0 !important;
                border: 0 !important;
                padding: 0 !important;
            }

            .select2-results,
            .select2-dropdown,
            .select2-container--open .select2-dropdown--below {
                position: relative;
                z-index: 99999999999999;
            }


            #submit-filters {
                position: inherit !important;
                border: 1px solid #CCC;
                width: 90% !important;
                padding: 10px !important;
                margin: 0 auto;
                margin: 10px auto;
                font-size: 9px;
            }

            .mobile-title {
                margin: 0 !important;
                padding: 0 !important;
            }



            .mobile-title {
                padding-bottom: 10px;
                padding-top: 10px !important;
                margin-bottom: 10px !important;
            }

            #sort-select option {
                text-align: center;
                justify-content: center;
                display: flex;
                align-items: center;
                margin: 0 auto;
                width: 100%;
            }

            #sort-select {
                text-transform: capitalize;
                background: #f0f0f0 !important;
                padding: 6px !important;
                cursor: pointer;
                border: 0 !important;
                width: 50% !important;
                border-radius: 0 !important;
                text-align: center;
                display: flex;
                color: black !important;
                padding: 0 !important;
                margin: 0 !important;
                height: 35px !important;
                border-left: 1px solid #c9c9c9 !important;
                align-items: center;
                justify-content: center;
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-position: right center;

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
                font-size: 9px;
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

        #sorting-options {
            display: flex !important;
            justify-content: space-around;
            text-align: center;
        }



        .trip-search input {
            background: #f5f5f5;
            border: none;
            width: 100%;
            height: 35px;
            padding-left: 20px;
            font-weight: 500;
            border-radius: 0;
        }

        .hidden {
            display: none !important;
        }

        .button-effect-div {
            display: flex;
            opacity: inherit !important;
        }


        input[type="radio"] {
            display: grid;
            place-content: center;
        }

        input[type=radio]:checked {
            background: none !important;
        }


        input[type="radio"] {
            display: grid;
            place-content: center;
            width: 15px !important;
            height: 15px !important;
            margin-left: 3px !important;
        }

        input[type="radio"]:checked::before {
            transform: scale(1);
        }

        input[type="radio"]::before {
            transform-origin: bottom left;
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        input[type="radio"]::before {
            background-color: black;
        }

        input[type="radio"]::before {
            content: "";
            width: 0.65em;
            height: 0.65em;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em var(--form-control-color);
        }
    </style>
@endsection
