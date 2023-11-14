@extends('client.layouts.master')

@section('content')
    <style>
        /* css */
        .trip-search select
        {
            appearance: none;
            border: 1px solid #CCC;
            border-radius: 8px;
        }

        input[type=radio]
        {
            appearance: none;
            background: white;
            border: 2px solid #0A0A0A;
            border-radius: 100%;
        }

        input[type=radio]:checked
        {
            background: #0A0A0A;
        }

        .widget-boxed-header h6
        {
            font-weight: bold !important;
            color: #000;
        }

        @media (min-width: 768px) {
            .filters-input-area {
                display: block !important;
            }
        }

        @media (max-width: 767px) {
            .filters-input-area {
                position: fixed;
                top: 0;
                right: 0;
                width: 90%;
                height: 100%;
                z-index: 999999999;
                background-color: white;
                padding: 16px;
                box-shadow: 0 0 48px rgba(0, 0, 0, .3);
                overflow-y: scroll;
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
                    <div class="widget filters-input-area" style="display: none;">
                        <svg height="24px" id="Layer_1" onclick="$(this).parent().slideToggle();" class="d-md-none"
                            style="float: left; margin-top: -24px; margin-bottom: 24px;enable-background:new 0 0 512 512;cursor: pointer;"
                            version="1.1" viewBox="0 0 512 512" width="24px" xml:space="preserve"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <path
                                d="M437.5,386.6L306.9,256l130.6-130.6c14.1-14.1,14.1-36.8,0-50.9c-14.1-14.1-36.8-14.1-50.9,0L256,205.1L125.4,74.5  c-14.1-14.1-36.8-14.1-50.9,0c-14.1,14.1-14.1,36.8,0,50.9L205.1,256L74.5,386.6c-14.1,14.1-14.1,36.8,0,50.9  c14.1,14.1,36.8,14.1,50.9,0L256,306.9l130.6,130.6c14.1,14.1,36.8,14.1,50.9,0C451.5,423.4,451.5,400.6,437.5,386.6z" />
                        </svg>
                        <!-- Search Fields -->

                        <div class="widget-boxed main-search-field mt-4">
                            <div class="trip-search">
                                <div class="widget-boxed-header border-0">
                                    <h6 style="font-weight: 700">Adres</h6>
                                </div>
                                <div>
                                    <select id="city" class="bg-white filter-now">
                                        <option value="#" class="selected" selected disabled>İl</option>
                                        @foreach ($cities as $city)
                                            <option value="{{ $city->id }}">{{ $city->title }}</option>
                                        @endforeach
                                    </select>
                                    <div onclick="$(this).parent().find('select').trigger('click');" class="border-left" style="float: right; margin-top: -43px; padding: 10px; cursor: pointer;">
                                        <svg viewBox="0 0 384 512" width="16" height="16" xmlns="http://www.w3.org/2000/svg"><path fill="#AAA" d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <select id="county" class="bg-white filter-now">
                                        <option value="#" class="selected" selected disabled>İlçe</option>
                                    </select>

                                    <div onclick="$(this).parent().find('select').trigger('click');" class="border-left" style="float: right; margin-top: -43px; padding: 10px; cursor: pointer;">
                                        <svg viewBox="0 0 384 512" width="16" height="16" xmlns="http://www.w3.org/2000/svg"><path fill="#AAA" d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <select id="neighborhood" class="bg-white filter-now">
                                        <option value="#" class="selected" selected disabled>Mahalle</option>
                                    </select>

                                    <div onclick="$(this).parent().find('select').trigger('click');" class="border-left" style="float: right; margin-top: -43px; padding: 10px; cursor: pointer;">
                                        <svg viewBox="0 0 384 512" width="16" height="16" xmlns="http://www.w3.org/2000/svg"><path fill="#AAA" d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="trip-search mt-5">
                                <div class="widget-boxed-header border-0">
                                    <h6 style="font-weight: 700">İlan Tarihi</h6>
                                </div>
                                <div style="display: grid;">
                                    <label class="filter-date d-flex align-items-center">
                                        <input name="filter-date" class="filter-date filter-now" type="radio" value="last3Days">
                                        <span class="fs-13 ml-2">Son 3 Gün</span>
                                    </label>
                                    <label class="filter-date mt-2 d-flex align-items-center">
                                        <input name="filter-date" class="filter-date filter-now" type="radio" value="lastWeek">
                                        <span class="fs-13 ml-2">Son Bir Hafta</span>
                                    </label>
                                     <label class="filter-date mt-2 d-flex align-items-center">
        <input name="filter-date" type="radio" class="filter-date filter-now" value="lastMonth">
        <span class="fs-13 ml-2">Son Bir Ay</span>
    </label>
                                </div>

                            </div>
                            @if ($secondhandHousings)
                                <div class="mt-4">
                                    <div class="trip-search">
                                        <div class="head d-flex">
                                            <b>Fiyat Aralığı</b>
                                        </div>
                                        <div class="mt-4 row price-inputs">
                                            <div class="col-6">
                                                <input type="number" id="price-min" min="0" placeholder="Min"
                                                       class="filter-now form-control">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" id="price-max" min="0" placeholder="Max"
                                                       class="filter-now form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="trip-search">
                                        <div class="head d-flex">
                                            <b>m<sup>2</sup> (brüt)</b>
                                        </div>
                                        <div class="mt-4 row">
                                            <div class="col-6">
                                                <input type="number" id="msq-min" min="0" placeholder="Min"
                                                       class="filter-now form-control">
                                            </div>
                                            <div class="col-6">
                                                <input type="number" id="msq-max" min="0" placeholder="Max"
                                                       class="filter-now form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4" id="room_count_field">
                                    <div class="head d-flex">
                                        <b>Oda Sayısı</b>
                                    </div>
                                    <div class="mt-4">
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now form-control"
                                                   id="1_1" />
                                            <label for="1_1" class="form-check-label w-100 ml-4">1+1</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now  form-control"
                                                   id="2_1" />
                                            <label for="2_1" class="form-check-label w-100 ml-4">2+1</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now  form-control"
                                                   id="3_1" />
                                            <label for="3_1" class="form-check-label w-100 ml-4">3+1</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now  form-control"
                                                   id="3_2" />
                                            <label for="3_2" class="form-check-label w-100 ml-4">3+2</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now  form-control"
                                                   id="4_1" />
                                            <label for="4_1" class="form-check-label w-100 ml-4">4+1</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now  form-control"
                                                   id="4_2" />
                                            <label for="4_2" class="form-check-label w-100 ml-4">4+2</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="checkbox" class="form-check-input filter-now  form-control"
                                                   id="5_1" />
                                            <label for="5_1" class="form-check-label w-100 ml-4">5+1</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4" id="from_owner_field">
                                    <div class="head d-flex">
                                        <b>Kimden</b>
                                    </div>
                                    <div class="mt-4">
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="radio" name="whose" id="from_owner" class="filter-now" />
                                            <label for="from_owner" class="form-check-label w-100 small">Sahibinden</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="radio" name="whose" id="from_office" class="filter-now" />
                                            <label for="from_office" class="form-check-label w-100 small">Emlak
                                                Ofisinden</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="radio" name="whose" id="from_company" class="filter-now" />
                                            <label for="from_company" class="form-check-label w-100 small">İnşaat
                                                Firmasından</label>
                                        </div>
                                        <div class="mb-2 d-flex align-items-center w-100">
                                            <input type="radio" name="whose" id="from_bank" class="filter-now" />
                                            <label for="from_bank" class="form-check-label w-100 small">Bankadan</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4" id="number_of_bathrooms">
                                    <div class="head d-flex">
                                        <b>Banyo Sayısı</b>
                                    </div>
                                    <div class="mt-4">
                                        <div class="d-flex current-page" style="border: 1px solid #CCC; cursor: pointer; border-radius: 8px;">
                                            <div style="border-radius: 8px 0 0 8px;" class="bathroom-count-item cursor-pointer border-right py-2 px-3 font-weight-bold w-100 text-center">
                                                1
                                            </div>
                                            <div class="bathroom-count-item cursor-pointer border-right py-2 px-3 font-weight-bold w-100 text-center">
                                                2
                                            </div>
                                            <div class="bathroom-count-item cursor-pointer border-right py-2 px-3 font-weight-bold w-100 text-center">
                                                3
                                            </div>
                                            <div style="border-radius: 0px 8px 8px 0;" class="bathroom-count-item cursor-pointer py-2 px-3 font-weight-bold w-100 text-center">
                                                4+
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @if ($projects)
                                <div class="trip-search mt-5">
                                    <div class="widget-boxed-header border-0">
                                        <h6 style="font-weight: 700">Proje Durumu</h6>
                                    </div>
                                    <div>
                                        <select id="project_type" class="form-control bg-white filter-now">
                                            <option value="#" selected disabled>Proje Durumu</option>
                                            <option value="2">Tamamlanan Projeler</option>
                                            <option value="3">Devam Eden Projeler</option>
                                            <option value="5">Topraktan Projeler</option>
                                        </select>

                                        <div onclick="$(this).parent().find('select').trigger('click');" class="border-left" style="float: right; margin-top: -43px; padding: 10px; cursor: pointer;">
                                            <svg viewBox="0 0 384 512" width="16" height="16" xmlns="http://www.w3.org/2000/svg"><path fill="#AAA" d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z"/></svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" class=" btn bg-white btn-lg btn-block mt-4 mb-4e btn-transition" style="border: 1px solid #CCC;"
                            id="clear-filters">Temizle</button>

                        <button type="button" onclick="$('.filters-input-area').slideToggle();"
                            style="background: #e54242 !important"
                            class="btn btn-secondary btn-lg btn-block mt-4 d-md-none mb-4"
                            id="close-filters">Kapat</button>

                    </div>
                </aside>

                <div class="col-lg-9 col-md-12 blog-pots order-1">
                    <section class="headings-2 pt-0 d-md-flex" style="display: grid;">
                        <div class="brand-head" style="padding-top: 0">
                            <div class="brands-square" style="position: relative; top: 0; left: 0">
                                <p class="brand-name"><a href="{{ url('/') }}" style="color: black">Anasayfa</a></p>
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
                    <section id="pages" class="d-flex justify-content-center" style="gap: 12px;">
                    </section>

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
                                <b>Adres</b>
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

                    @if ($secondhandHousings)
                        <div class="widget-boxed main-search-field mt-4">
                            <div class="trip-search">
                                <div class="head d-flex">
                                    <b>Fiyat Aralığı</b>
                                    <span class="ml-auto"
                                        onclick="$(this).parent().parent().find('.mt-4').slideToggle();">
                                        <svg width="16px" height="16px" viewBox="0 0 384 512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-4 row price-inputs" style="display: none;">
                                    <div class="col-6">
                                        <input type="number" id="price-min" min="0" placeholder="Min"
                                            class="filter-now form-control">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" id="price-max" min="0" placeholder="Max"
                                            class="filter-now form-control">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="widget-boxed main-search-field mt-4">
                            <div class="trip-search">
                                <div class="head d-flex">
                                    <b>m<sup>2</sup> (brüt)</b>
                                    <span class="ml-auto"
                                        onclick="$(this).parent().parent().find('.mt-4').slideToggle();">
                                        <svg width="16px" height="16px" viewBox="0 0 384 512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="mt-4 row" style="display: none;">
                                    <div class="col-6">
                                        <input type="number" id="msq-min" min="0" placeholder="Min"
                                            class="filter-now form-control">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" id="msq-max" min="0" placeholder="Max"
                                            class="filter-now form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-boxed mt-4" id="room_count_field">
                            <div class="head d-flex">
                                <b>Oda Sayısı</b>
                                <span class="ml-auto" onclick="$(this).parent().parent().find('.mt-4').slideToggle();">
                                    <svg width="16px" height="16px" viewBox="0 0 384 512"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-4" style="display: none;">
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now form-control"
                                        id="1_1" />
                                    <label for="1_1" class="form-check-label w-100 ml-4">1+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now  form-control"
                                        id="2_1" />
                                    <label for="2_1" class="form-check-label w-100 ml-4">2+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now  form-control"
                                        id="3_1" />
                                    <label for="3_1" class="form-check-label w-100 ml-4">3+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now  form-control"
                                        id="3_2" />
                                    <label for="3_2" class="form-check-label w-100 ml-4">3+2</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now  form-control"
                                        id="4_1" />
                                    <label for="4_1" class="form-check-label w-100 ml-4">4+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now  form-control"
                                        id="4_2" />
                                    <label for="4_2" class="form-check-label w-100 ml-4">4+2</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input filter-now  form-control"
                                        id="5_1" />
                                    <label for="5_1" class="form-check-label w-100 ml-4">5+1</label>
                                </div>
                            </div>
                        </div
                        <div class="widget-boxed mt-4" id="from_owner_field">
                            <div class="head d-flex">
                                <b>Kimden</b>
                                <span class="ml-auto" onclick="$(this).parent().parent().find('.mt-4').slideToggle();">
                                    <svg width="16px" height="16px" viewBox="0 0 384 512"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M192 384c-8.188 0-16.38-3.125-22.62-9.375l-160-160c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L192 306.8l137.4-137.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-160 160C208.4 380.9 200.2 384 192 384z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="mt-4" style="display: none;">
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="radio" name="whose" id="from_owner" class="filter-now" />
                                    <label for="from_owner" class="form-check-label w-100 small">Sahibinden</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="radio" name="whose" id="from_office" class="filter-now" />
                                    <label for="from_office" class="form-check-label w-100 small">Emlak
                                        Ofisinden</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="radio" name="whose" id="from_company" class="filter-now" />
                                    <label for="from_company" class="form-check-label w-100 small">İnşaat
                                        Firmasından</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="radio" name="whose" id="from_bank" class="filter-now" />
                                    <label for="from_bank" class="form-check-label w-100 small">Bankadan</label>
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="button" class="btn btn-primary btn-lg btn-block mt-4 mb-4"
                        id="clear-filters">Temizle</button>

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

        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        $('.bathroom-count-item').on('click', function()
        {
            $('.bathroom-count-item').removeClass('bg-dark').removeClass('text-white');
            $(this).addClass('bg-dark').addClass('text-white');
            bathroom_count = $(this).text();
        });

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




        function drawList(filters = {}) {
            function formatDate(rawDate) {
                const options = {
                    month: 'long',
                    day: 'numeric'
                };
                const date = new Date(rawDate);
                return new Intl.DateTimeFormat('tr-TR', options).format(date);
            }

            var slug = @json($slug ?? null);
            var type = @json($housingTypeSlug ?? null);
            var title = @json($housingTypeSlug ?? null);
            var optional = @json($opt ?? null);


            $.ajax({
                method: "POST",
                url: "{{ route($secondhandHousings ? 'get-rendered-secondhandhousings' : 'get-rendered-projects') }}",
                data: Object.assign({}, filters, {
                    _token: "{{ csrf_token() }}",
                    slug: slug,
                    type: type,
                    title: title,
                    optional: optional

                }),
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
                        console.log(response);
                        var assetPath = "{{ asset('images/sc.png') }}";

                        response.data.forEach((res) => {
                            @if (!$secondhandHousings)
                                $('.pp-row').append(
                                    `
                                    <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                        <!-- Image Box -->
                                        <a href="${res.url}" class="img-box hover-effect">
                                            <img src="${res.image}" class="img-fluid w100" alt="">

                                        </a>
                                    </div>
                                    `
                                );
                                $('.pp-col').append(
                                    `
                                    <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                        <!-- Image Box -->
                                        <a href="${res.url}" class="img-box hover-effect">
                                            <img src="${res.image}" class="img-fluid w100" alt="">

                                        </a>
                                    </div>
                                    `
                                );
                            @else
                                $('.pp-row').append(
                                    `
                                    <div class="agents-grid col-md-4" data-aos="fade-up" data-aos-delay="150">
                                        <a href="${res.housing_url}" tabindex="0" class="text-decoration-none">
                                        <div class="landscapes">
                                            <div class="project-single">

                                                <div class="project-inner project-head">
                                                    <div class="homes">
                                                        <!-- homes img -->
                                                        <a href="${res.housing_url}" class="homes-img">
                                                            <img src="${res.image}" alt="${res.housing_type_title}"
                                                                 class="img-responsive">
                                                        </a>
                                                    </div>
                                                    <div class="button-effect">
                                                        <!-- Örneğin Kalp İkonu -->
                                                        <a href="" class="btn toggle-favorite bg-white ${res.in_favorites ? 'bg-white' : ''}"
                                                           data-housing-id="${res.id}">
                                                            <i class="fa fa-heart-o ${res.in_favorites ? 'text-danger' : ''}"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- homes content -->
                                                <div class="homes-content p-3" style="padding:20px !important; ${res.sold ? 'background: #EEE !important;' : ''}">
                                                    <!-- homes address -->
                                                    <a href="${res.housing_url}">
                                                    <h4>${res.title}</h4>
                                                    </a>
                                                    <p class="homes-address mb-3">
                                                        <a href="${res.housing_url}">
                                                            <i class="fa fa-map-marker"></i><span>                ${res.city.title} ${"/"} ${res.county.ilce_title}</span>
                                                        </a>
                                                    </p>
                                                    <!-- homes List -->
                                                    <ul class="homes-list clearfix pb-0" style="display: flex;justify-content:space-between">
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                            <span>${res.housing_type.title} </span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                            <span>${res.housing_type.room_count}</span>
                                                        </li>
                                                        <li class="sude-the-icons" style="width:auto !important">
                                                            <i class="fa fa-circle circleIcon mr-1"></i>
                                                            <span>${res.housing_type.squaremeters} m2</span>
                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                        <li style="font-size: 16px; font-weight: 700;" class="priceFont">
                                                            ${numberFormat(res.housing_type.price)} ₺

                                                        </li>
                                                        <li style="display: flex; justify-content: center;">
                                                            ${formatDate(res.created_at)}

                                                        </li>
                                                    </ul>
                                                    <ul class="homes-list clearfix pb-0" style="display: flex; justify-content: center;">
                                                        ${res.sold ?
                                                            `<button
                                                                                                                                                                                                    style="width: 100%; border: none; background-color: #EA2B2E; border-radius: 10px; padding: 5px 0px; color: white;">Satıldı
                                                                                                                                                                                                </button>`
                                                            :

                                                            `
                                                                                                                                                        <button class="CartBtn ${res.in_cart ? 'bg-success text-white' : ''}" data-type='housing'
                                                                                                                                                        data-id='${res.id}'>
                                                                                                                                                        <span class="IconContainer">
                                                                                                                                                            <img src="{{ asset('sc.png') }}" alt="">

                                                                                                                                                        </span>
                                                                                                                                                        <span class="text text-white">${res.in_cart ? 'Sepete Eklendi' : 'Sepete Ekle'}</span>
                                                                                                                                                    </button>
                                                                                                                                                        `
                                                            }
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    `
                                );
                                $('.pp-col').append(`

                                    <div class="d-flex" style="flex-wrap: nowrap">
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
                                                    <h4>
                                                        ${res.title} ${' '}${res.housing_type.squaremeters ?? '?' }m2 ${res.housing_type.room_count ?? '?' }
                                                    </h4>
                                                </a>
                                                <div class="d-flex">
                                                    <div class="d-flex" style="gap: 8px;">
                                                        <a href="#" class="btn toggle-favorite bg-white" data-housing-id="${res.id}" style="color: white;">
                                                            <i class="fa fa-heart-o"></i>
                                                        </a>
                                                        <button class="addToCart mobile px-2"
                                                                                style="width: 100%; border: none; background-color: #274abb; border-radius: .25rem; padding: 5px 0px; color: white;"
                                                                                data-type='housing' data-id='${res.id}'>
                                                                                <img src="{{ asset('images/sc.png') }}" alt="sc" width="24px"
                                                                                    height="24px"
                                                                                    style="width: 24px !important; height: 24px !important;" />
                                                                            </button>

                                                    </div>
                                                    <span class="ml-auto text-primary priceFont">
                                                        ${numberFormat(res.housing_type.price)} ₺
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-100" style="height:40px;background-color:#8080802e;margin-top:20px">
                                        <ul class="d-flex justify-content-around align-items-center h-100"
                                            style="list-style: none;padding:0;font-weight:600">
                                            <li class="d-flex align-items-center itemCircleFont">
                                                <i class="fa fa-circle circleIcon"></i>
                                            No: ${res.id}
                                            </li>
                                            <li class="d-flex align-items-center itemCircleFont">
                                                <i class="fa fa-circle circleIcon"></i>
                                                ${res.housing_type.squaremeters ?? null } m2
                                            </li>
                                            <li class="d-flex align-items-center itemCircleFont">
                                                <i class="fa fa-circle circleIcon"></i>
                                                ${res.housing_type.room_count ?? null }
                                            </li>
                                            <li class="d-flex align-items-center itemCircleFont" >
                                                <i class="fa fa-circle circleIcon"></i>
                                                ${res.city.title} ${"/"} ${res.county.ilce_title}
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                `);
                            @endif
                        });
                    } else {
                        $('.pp-row').html(`
                        <div class="col-12 text-center my-4 font-weight-bold p-3">Sonuç bulunamadı.</div>
                        `);
                        $('.pp-col').html(`
                        <div class="col-12 text-center my-4 font-weight-bold p-3">Sonuç bulunamadı.</div>
                        `);
                    }
                }
            });
        }

        // Sıralama seçenekleri için
        $('#sort-select').on('change', function() {
            var selectedValue = $(this).val();
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

            drawList(filters);
        });



        $(function() {
            drawList();

            function filterNow() {
                let room_count = [];
                $('#room_count_field .mt-4 .mb-2').each(function() {
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

                drawList({
                    page: current_page,
                    city: $('#city').val(),
                    county: $('#county').val(),
                    project_type: $("#project_type").val(),
                    neighborhood: $('#neighborhood').val(),
                    filterDate: $(".filter-date:checked").val(),
                    @if ($secondhandHousings)
                        price_min: $('#price-min').val(),
                        price_max: $('#price-max').val(),
                        msq_min: $('#msq-min').val(),
                        msq_max: $('#msq-max').val(),
                        room_count,
                        post_date,
                        from_owner,
                        bathroom_count,
                    @endif
                });
            }

            $('#clear-filters').on('click', function() {
                $('#city').val('#');
                $('#county').val('#');
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
        hr {
            width: 100%;
            height: 100%;
        }

        .homes-content h4 {
            height: 60px !important;
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
                font-size: 14px;
            }
        }
    </style>
@endsection
