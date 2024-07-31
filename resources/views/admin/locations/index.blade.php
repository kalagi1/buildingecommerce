@extends('admin.layouts.master')

@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <ul id="cityList" class="list-group">
                    @foreach ($cities as $city)
                        <li class="list-group-item city-item" data-city-id="{{ $city->id }}">
                            <button class="btn btn-link toggle-button">
                                {{ $city->title }} (NO: {{ $city->id }})
                                <span class="toggle-icon">▼</span>
                            </button>
                            <div class="city-details" style="display: none;">
                                <div class="form-group">
                                    <label for="metaDescription{{ $city->id }}">Şehir Meta Açıklaması</label>
                                    <textarea class="form-control city-meta-description" id="metaDescription{{ $city->id }}" rows="3">{{ $city->meta_description ?? '' }}</textarea>
                                </div>
                                <div class="district-list"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <button id="saveMetaDescriptions" class="btn btn-primary mt-3">Meta Açıklamaları Kaydet</button>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var metaDescriptions = {};

            function showLoading($container) {
                $container.html('<div class="text-center">Yükleniyor...</div>');
            }

            function updateMetaDescriptions() {
                $('.city-meta-description').each(function() {
                    var cityId = $(this).attr('id').replace('metaDescription', '');
                    var description = $(this).val();
                    metaDescriptions[cityId] = { city: description };
                });

                $('.district-meta-description').each(function() {
                    var districtId = $(this).attr('id').replace('districtDescription', '');
                    var description = $(this).val();
                    if (!metaDescriptions[districtId]) {
                        metaDescriptions[districtId] = {};
                    }
                    metaDescriptions[districtId].district = description;
                });

                $('.neighborhood-meta-description').each(function() {
                    var neighborhoodId = $(this).attr('id').replace('neighborhoodDescription', '');
                    var description = $(this).val();
                    var districtId = $(this).closest('.district-details').prev().data('district-id');
                    if (!metaDescriptions[districtId]) {
                        metaDescriptions[districtId] = {};
                    }
                    if (!metaDescriptions[districtId].neighborhoods) {
                        metaDescriptions[districtId].neighborhoods = {};
                    }
                    metaDescriptions[districtId].neighborhoods[neighborhoodId] = description;
                });
            }

            $('#cityList').on('click', '.toggle-button', function() {
                var $cityItem = $(this).closest('.city-item');
                var cityId = $cityItem.data('city-id');
                var $cityDetails = $cityItem.find('.city-details');
                var $districtList = $cityItem.find('.district-list');
                var $toggleIcon = $(this).find('.toggle-icon');

                if ($cityDetails.is(':visible')) {
                    $cityDetails.slideUp();
                    $toggleIcon.text('▼');
                } else {
                    if ($districtList.is(':empty')) {
                        showLoading($districtList);
                        $.ajax({
                            url: '{{ route('admin.locations.getDistricts') }}',
                            method: 'GET',
                            data: { city_id: cityId },
                            success: function(data) {
                                var districtsHtml = '<div class="list-group mt-2">';
                                $.each(data, function(index, district) {
                                    districtsHtml += '<div class="list-group-item">';
                                    districtsHtml += '<button class="btn btn-link toggle-district-button" data-district-id="' + district.ilce_key + '">';
                                    districtsHtml += district.ilce_title;
                                    districtsHtml += '<span class="toggle-icon">▼</span>';
                                    districtsHtml += '</button>';
                                    districtsHtml += '<div class="district-details" style="display: none;">';
                                    districtsHtml += '<div class="form-group">';
                                    districtsHtml += '<label for="districtDescription' + district.ilce_key + '">İlçe Meta Açıklaması</label>';
                                    districtsHtml += '<textarea class="form-control district-meta-description" id="districtDescription' + district.ilce_key + '" rows="3">' + (district.meta_description ?? '') + '</textarea>';
                                    districtsHtml += '</div>';
                                    districtsHtml += '<div class="neighborhood-list"></div>';
                                    districtsHtml += '</div>';
                                    districtsHtml += '</div>';
                                });
                                districtsHtml += '</div>';
                                $districtList.html(districtsHtml);
                            },
                            error: function() {
                                $districtList.html('<div class="text-center text-danger">İlçeler yüklenirken bir hata oluştu.</div>');
                            }
                        });
                    }
                    $cityDetails.slideDown();
                    $toggleIcon.text('▲');
                }
            });

            $('#cityList').on('click', '.toggle-district-button', function() {
                var $districtItem = $(this).closest('.list-group-item');
                var districtId = $(this).data('district-id');
                var $districtDetails = $districtItem.find('.district-details');
                var $neighborhoodList = $districtItem.find('.neighborhood-list');
                var $toggleIcon = $(this).find('.toggle-icon');

                if ($districtDetails.is(':visible')) {
                    $districtDetails.slideUp();
                    $toggleIcon.text('▼');
                } else {
                    if ($neighborhoodList.is(':empty')) {
                        showLoading($neighborhoodList);
                        $.ajax({
                            url: '{{ route('admin.locations.getNeighborhoods') }}',
                            method: 'GET',
                            data: { district_id: districtId },
                            success: function(data) {
                                var neighborhoodsHtml = '<div class="list-group mt-2">';
                                $.each(data, function(index, neighborhood) {
                                    neighborhoodsHtml += '<div class="list-group-item">';
                                    neighborhoodsHtml += '<button class="btn btn-link toggle-neighborhood-button" data-neighborhood-id="' + neighborhood.mahalle_id + '">';
                                    neighborhoodsHtml += neighborhood.mahalle_title;
                                    neighborhoodsHtml += '<span class="toggle-icon">▼</span>';
                                    neighborhoodsHtml += '</button>';
                                    neighborhoodsHtml += '<div class="neighborhood-details" style="display: none;">';
                                    neighborhoodsHtml += '<div class="form-group">';
                                    neighborhoodsHtml += '<label for="neighborhoodDescription' + neighborhood.mahalle_id + '">Mahalle Meta Açıklaması</label>';
                                    neighborhoodsHtml += '<textarea class="form-control neighborhood-meta-description" id="neighborhoodDescription' + neighborhood.mahalle_id + '" rows="3">' + (neighborhood.meta_description ?? '') + '</textarea>';
                                    neighborhoodsHtml += '</div></div>';
                                    neighborhoodsHtml += '</div>';
                                });
                                neighborhoodsHtml += '</div>';
                                $neighborhoodList.html(neighborhoodsHtml);
                            },
                            error: function() {
                                $neighborhoodList.html('<div class="text-center text-danger">Mahalleler yüklenirken bir hata oluştu.</div>');
                            }
                        });
                    }
                    $districtDetails.slideDown();
                    $toggleIcon.text('▲');
                }
            });

            $('#cityList').on('click', '.toggle-neighborhood-button', function() {
                var $neighborhoodItem = $(this).closest('.list-group-item');
                var $neighborhoodDetails = $neighborhoodItem.find('.neighborhood-details');
                var $toggleIcon = $(this).find('.toggle-icon');

                if ($neighborhoodDetails.is(':visible')) {
                    $neighborhoodDetails.slideUp();
                    $toggleIcon.text('▼');
                } else {
                    $neighborhoodDetails.slideDown();
                    $toggleIcon.text('▲');
                }
            });

            // Track changes in textareas and update metaDescriptions
            $('#cityList').on('input', '.city-meta-description, .district-meta-description, .neighborhood-meta-description', function() {
                updateMetaDescriptions();
            });

            $('#saveMetaDescriptions').click(function() {
                $.ajax({
                    url: '{{ route('admin.locations.saveMetaDescriptions') }}',
                    method: 'POST',
                    data: {
                        meta_descriptions: metaDescriptions,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert('Meta açıklamaları başarıyla güncellendi!');
                    },
                    error: function() {
                        alert('Meta açıklamaları güncellenirken bir hata oluştu.');
                    }
                });
            });
        });
    </script>
@endsection
