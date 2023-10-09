@extends('client.layouts.master')

@section('content')
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

            <div class="row project-filter-reverse">
                <aside class="col-lg-3 col-md-12 car">
                    <div class="widget">
                        <!-- Search Fields -->
                        <div class="widget-boxed main-search-field">
                            <div class="trip-search">
                                <b>Adres:</b>
                                <div class="mt-4">
                                    <select id="city" class="form-control bg-white">
                                        <option value="#" selected disabled>İl</option>
                                        @foreach ($cities as $city)
                                        <option value="{{$city->id}}">{{$city->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <select id="county" class="form-control bg-white">
                                        <option value="#" disabled>İlçe</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if ($secondhandHousings)
                        <div class="widget-boxed main-search-field mt-4">
                            <div class="trip-search">
                                <b>Fiyat Aralığı:</b>
                                <div class="mt-4 row">
                                    <div class="col-6">
                                        <input type="number" id="price-min" min="0" placeholder="Min Fiyat" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" id="price-max" min="0" placeholder="Max Fiyat" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-boxed main-search-field mt-4">
                            <div class="trip-search">
                                <b>m<sup>2</sup> (Brüt):</b>
                                <div class="mt-4 row">
                                    <div class="col-6">
                                        <input type="number" id="msq-min" min="0" placeholder="Min" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" id="msq-max" min="0" placeholder="Max" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-boxed mt-4" id="room_count_field">
                            <b>Oda Sayısı:</b>
                            <div class="mt-4">
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="1_1"/>
                                    <label for="1_1" class="form-check-label w-100 ml-4">1+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="2_1"/>
                                    <label for="2_1" class="form-check-label w-100 ml-4">2+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="3_1"/>
                                    <label for="3_1" class="form-check-label w-100 ml-4">3+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="3_2"/>
                                    <label for="3_2" class="form-check-label w-100 ml-4">3+2</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="4_1"/>
                                    <label for="4_1" class="form-check-label w-100 ml-4">4+1</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="4_2"/>
                                    <label for="4_2" class="form-check-label w-100 ml-4">4+2</label>
                                </div>
                                <div class="mb-2 d-flex align-items-center w-100">
                                    <input type="checkbox" class="form-check-input" id="5_1"/>
                                    <label for="5_1" class="form-check-label w-100 ml-4">5+1</label>
                                </div>
                            </div>
                        </div>

                        <div class="widget-boxed mt-4" id="post_date_field">
                            <b>İlan Tarihi:</b>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="post_date" id="recent_day"/>
                                <label for="recent_day" class="form-check-label w-100 small">Son 1 Gün İçinde</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="post_date" id="last_3_day"/>
                                <label for="last_3_day" class="form-check-label w-100 small">Son 3 Gün İçinde</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="post_date" id="last_7_day"/>
                                <label for="last_7_day" class="form-check-label w-100 small">Son 7 Gün İçinde</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="post_date" id="last_15_day"/>
                                <label for="last_15_day" class="form-check-label w-100 small">Son 15 Gün İçinde</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="post_date" id="last_30_day"/>
                                <label for="last_30_day" class="form-check-label w-100 small">Son 30 Gün İçinde</label>
                            </div>
                        </div>

                        <div class="widget-boxed mt-4" id="from_owner_field">
                            <b>Kimden:</b>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="whose" id="from_owner"/>
                                <label for="from_owner" class="form-check-label w-100 small">Sahibinden</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="whose" id="from_office"/>
                                <label for="from_office" class="form-check-label w-100 small">Emlak Ofisinden</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="whose" id="from_company"/>
                                <label for="from_company" class="form-check-label w-100 small">İnşaat Firmasından</label>
                            </div>
                            <div class="mb-2 d-flex align-items-center w-100">
                                <input type="radio" name="whose" id="from_bank"/>
                                <label for="from_bank" class="form-check-label w-100 small">Bankadan</label>
                            </div>
                        </div>
                        @endif

                        <div class="widget-boxed mt-4">
                            <button type="button" id="set-filter" class="btn btn-lg btn-block btn-primary">FİLTRELE</button>
                        </div>

                    </div>
                </aside>
                <div class="col-lg-9 col-md-12 blog-pots">
                    <section class="headings-2 pt-0">
                        <div class="brand-head" style="padding-top:0">
                            <div class="brands-square" style="position: relative;top:0;left:0">
                                <p class="brand-name"><a href="{{ url('/') }}" style="color:black">Anasayfa</a></p>
                                <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i> </p>
                                <p class="brand-name" style="color: black">
                                    Kategori
                                </p>
                                <p class="brand-name"><i class="fa fa-angle-right" style="color: black"></i> </p>
                                <p class="brand-name" style="color: black">
                                    {{ $title }}
                                </p>
                            </div>
                        </div>
                    </section>
                    <section class="popular-places home18" style="padding-top:0 !important">
                        <div class="container">

                            <div class="row pp-row">
                                {{--
                                @if (count($secondhandHousings) == 0)
                                    @forelse($projects as $project)
                                        <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                            <!-- Image Box -->
                                            <a href="{{ route('project.detail', $project->slug) }}"
                                                class="img-box hover-effect">
                                                <img src="{{ URL::to('/') . '/' . str_replace('public/', 'storage/', $project->image) }}"
                                                    class="img-fluid w100" alt="">
                                            </a>
                                        </div>
                                    @empty
                                        <div class="col-sm-12">
                                            <strong>Bu kategoriye ait proje bulunamadı.</strong>
                                        </div>
                                    @endforelse
                                @else
                                    <div class="slick-agentsx row mt-3">
                                        @foreach ($secondhandHousings as $housing)
                                            <div class="agents-grid col-md-4" data-aos="fade-up" data-aos-delay="150">
                                                <div class="landscapes">
                                                    <div class="project-single">
                                                        <div class="project-inner project-head">
                                                            <div class="homes">
                                                                <!-- homes img -->
                                                                <a href="single-property-1.html" class="homes-img">
                                                                    <img src="{{ asset('housing_images/' . getImage($housing, 'image')) }}"
                                                                        alt="{{ $housing->housing_type_title }}"
                                                                        class="img-responsive">
                                                                </a>
                                                            </div>
                                                            <div class="button-effect">
                                                                <!-- Örneğin Kalp İkonu -->
                                                                <a href="#" class="btn toggle-favorite"
                                                                    data-housing-id="{{ $housing->id }}">
                                                                    <i class="fa fa-heart"></i>
                                                                </a>

                                                            </div>
                                                        </div>
                                                        <!-- homes content -->
                                                        <div class="homes-content p-3" style="padding:20px !important">
                                                            <!-- homes address -->
                                                            <h3><a
                                                                    href="{{ route('housing.show', $housing->id) }}">{{ $housing->title }}</a>
                                                            </h3>
                                                            <p class="homes-address mb-3">
                                                                <a href="{{ route('housing.show', $housing->id) }}">
                                                                    <i
                                                                        class="fa fa-map-marker"></i><span>{{ $housing->address }}</span>
                                                                </a>
                                                            </p>
                                                            <!-- homes List -->
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex;justify-content:space-between">
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                                    <span>{{ $housing->housing_type->title }} </span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="flaticon-bathtub mr-2"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getData($housing, 'room_count') }}</span>
                                                                </li>
                                                                <li class="sude-the-icons" style="width:auto !important">
                                                                    <i class="flaticon-square mr-2"
                                                                        aria-hidden="true"></i>
                                                                    <span>{{ getData($housing, 'squaremeters') }} m2</span>
                                                                </li>
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                                <li style="font-size: large; font-weight: 700;">
                                                                    {{ getData($housing, 'price') }}TL</li>

                                                                <li style="display: flex; justify-content: center;">
                                                                    {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                                </li>
                                                            </ul>
                                                            <ul class="homes-list clearfix pb-0"
                                                                style="display: flex; justify-content: center;margin-top:20px !important;">
                                                                <button class="addToCart"
                                                                    style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                                    data-type='housing'
                                                                    data-id='{{ $housing->id }}'>Sepete
                                                                    Ekle</button>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach







                                    </div>
                                @endif
                                --}}
                            </div>
                        </div>
                    </section>

                </div>

            </div>

        </div>
    </section>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script></script>
    <script>
        'use strict';
        $('#city').on('change', function()
        {
            $.ajax(
                {
                    method: "GET",
                    url: "{{url('get-counties-for-client')}}/"+$(this).val(),
                    success: function(res)
                    {
                        $('#county').empty();
                        $('#county').append('<option value="#" disabled>İlçe</option>');
                        res.forEach((e) =>
                        {
                            $('#county').append(
                                `<option value="${e.id}">${e.title}</option>`
                            );
                        });
                    }
                }
            );
        });

        function drawList(filters = {})
        {
            $.ajax(
                {
                    method: "POST",
                    url: "{{ route($secondhandHousings ? 'get-rendered-secondhandhousings' : 'get-rendered-projects') }}",
                    data: Object.assign({}, filters, { _token: "{{csrf_token()}}" }),
                    success: function(response)
                    {
                        $('.pp-row').empty();

                        response.forEach((res) =>
                        {
                            @if (!$secondhandHousings)
                            $('.pp-row').append(
                                `
                                <div class="col-sm-12 col-md-6 col-lg-6" data-aos="zoom-in" data-aos-delay="150">
                                    <!-- Image Box -->
                                    <a href="${res.url}"
                                        class="img-box hover-effect">
                                        <img src="${res.image}"
                                            class="img-fluid w100" alt="">
                                    </a>
                                </div>
                                `
                            );
                            @else
                            $('.pp-row').append(
                                `
                                <div class="agents-grid col-md-4" data-aos="fade-up" data-aos-delay="150">
                                    <div class="landscapes">
                                        <div class="project-single">
                                            <div class="project-inner project-head">
                                                <div class="homes">
                                                    <!-- homes img -->
                                                    <a href="single-property-1.html" class="homes-img">
                                                        <img src="${res.image}"
                                                            alt="${res.housing_type_title}"
                                                            class="img-responsive">
                                                    </a>
                                                </div>
                                                <div class="button-effect">
                                                    <!-- Örneğin Kalp İkonu -->
                                                    <a href="#" class="btn toggle-favorite"
                                                        data-housing-id="${res.housing_id}">
                                                        <i class="fa fa-heart"></i>
                                                    </a>

                                                </div>
                                            </div>
                                            <!-- homes content -->
                                            <div class="homes-content p-3" style="padding:20px !important">
                                                <!-- homes address -->
                                                <h3><a
                                                        href="${res.housing_url}">${res.title}</a>
                                                </h3>
                                                <p class="homes-address mb-3">
                                                    <a href="${res.housing_url}">
                                                        <i
                                                            class="fa fa-map-marker"></i><span>${res.housing_address}</span>
                                                    </a>
                                                </p>
                                                <!-- homes List -->
                                                <ul class="homes-list clearfix pb-0"
                                                    style="display: flex;justify-content:space-between">
                                                    <li class="sude-the-icons" style="width:auto !important">
                                                        <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                        <span>${res.housing_type.title} </span>
                                                    </li>
                                                    <li class="sude-the-icons" style="width:auto !important">
                                                        <i class="flaticon-bathtub mr-2"
                                                            aria-hidden="true"></i>
                                                        <span>${res.housing_type.room_count}</span>
                                                    </li>
                                                    <li class="sude-the-icons" style="width:auto !important">
                                                        <i class="flaticon-square mr-2"
                                                            aria-hidden="true"></i>
                                                        <span>${res.housing_type.squaremeters} m2</span>
                                                    </li>
                                                </ul>
                                                <ul class="homes-list clearfix pb-0"
                                                    style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                    <li style="font-size: large; font-weight: 700;">
                                                        ${res.housing_type.price}TL</li>

                                                    <li style="display: flex; justify-content: center;">
                                                        ${res.housing_date}
                                                    </li>
                                                </ul>
                                                <ul class="homes-list clearfix pb-0"
                                                    style="display: flex; justify-content: center;margin-top:20px !important;">
                                                    <button class="addToCart"
                                                        style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                        data-type='housing'
                                                        data-id='${res.housing_id}'>Sepete
                                                        Ekle</button>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `
                            );
                            @endif
                        });
                    }
                }
            );
        }

        $(function()
        {
            drawList();

            $('#set-filter').on('click', function()
            {
                let room_count = [];
                $('#room_count_field .mt-4 .mb-2').each(function()
                {
                    let i = $(this).find('.form-check-input');

                    if (i.is(':checked'))
                    {
                        room_count.push(i.id().replace('_','+')); 
                    }
                });

                let post_date;
                $('#post_date_field .mb-2').each(function()
                {
                    let i = $(this).find('input[type=radio]');

                    if (i.is(':checked'))
                    {
                        post_date = i.id();
                        return false;
                    }
                });

                let from_owner;
                $('#from_owner_field .mb-2').each(function()
                {
                    let i = $(this).find('input[type=radio]');

                    if (i.is(':checked'))
                    {
                        from_owner = i.id();
                        return false;
                    }
                });

                drawList(
                    {
                        city: $('#city').val(),
                        county: $('#county').val(),
                        @if ($secondhandHousings)
                        price_min: $('#price-min').val(),
                        price_max: $('#price-max').val(),
                        msq_min: $('#msq-min').val(),
                        msq_max: $('#msq-max').val(),
                        room_count,
                        post_date,
                        from_owner,
                        @endif
                    }
                );
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
