@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        
        <div class="mt-4">
            <div class="second-area">
                <div class="row">
                    <div class="form-area mt-4">
                        <span class="section-title">İlan Detayları</span>
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <h4 class="c-fff">{{$errors->first()}}</h4>
                        </div>
                        @endif
                        <form action="{{route('institutional.projects.edit.housing.post',["project_id" => $project->id, "room_order" => $roomOrder])}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab-content" id="pricingTabContent" role="tabpanel">
                                        <div id="renderForm"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="second-area-finish">
                                <div class="finish-tick ">
                                    <input type="checkbox" value="1" class="rules_confirm">
                                    <span class="rulesOpen">İlan verme kurallarını</span>
                                    <span>okudum, kabul ediyorum</span>
                                </div>
                                <div class="finish-button" style="float:right;margin:0;">
                                    <button class="btn btn-info" type="submit">
                                        Devam
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var houseCount = {{ isset($project->room_count) ? $project->room_count : 0 }};
        console.log(houseCount);
        if (!isNaN(houseCount) && houseCount > 0) {
            var houseType = {{ isset($project->housing_type_id) ? $project->housing_type_id : 0 }};
            if (houseType != 0) {
                @if (isset($project->housing_type_id))
                    @php
                        $housingType = DB::table('housing_types')
                            ->where('id', $project->housing_type_id)
                            ->first();
                    @endphp
                    var housingTypeData = @json($housingType);
                    @if (isset($project->roomInfo))
                        var oldData = @json($project->roomInfo);
                    @else
                        var oldData = [];
                    @endif
                    var formInputs = JSON.parse(housingTypeData.form_json);
                @endif
                $('.rendered-area').removeClass('d-none')
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: houseType
                    },
                    success: function(response) {
                        var html = "";
                        var htmlContent = "";
                        for (var i = {{$roomOrder}}; i < {{$roomOrder + 1}}; i++) {

                            htmlContent += '<div class="tab-pane fade show active' +
                                '" id="TabContent' + (i) + '" role="tabpanel">' +
                                '<div id="renderForm' + (i) + '"></div>' +
                                '</div>';
                        }

                        $('.tab-content').html(htmlContent);

                        for (let i = {{$roomOrder}}; i < {{$roomOrder + 1}}; i++) {
                            formRenderOpts = {
                                dataType: 'json',
                                formData: response.form_json
                            };

                            var renderedForm = $('<div>');
                            renderedForm.formRender(formRenderOpts);
                            var renderHtml = renderedForm.html().toString();
                            renderHtml = renderHtml.toString().split('images[][]');
                            renderHtml = renderHtml[0];
                            var json = JSON.parse(response.form_json);
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    var json = JSON.parse(response.form_json);
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '-');
                                    renderHtmlx = "";
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[]-' + i;
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }

                                    renderHtml = renderHtmlx;
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '[]');
                                    renderHtmlx = "";
                                    var json = JSON.parse(response.form_json);
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[][]';
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }


                                    renderHtml = renderHtmlx;


                                }
                            }
                            $('#renderForm' + (i)).html(renderHtmlx);

                            if (i > 1 && i != $('.tab-pane').length) {
                                $('.rendered-form').eq(i - 1).append(
                                    '<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button><button class="next_house btn btn-primary">Sonraki Konut</button></div>'
                                )
                            } else if (i == $('.tab-pane').length) {
                                $('.rendered-form').eq(i - 1).append(
                                    '<div class="housing_buttons"><button class="prev_house btn btn-primary">Önceki Ev</button></div>'
                                )
                            } else {
                                $('.rendered-form').eq(i - 1).append(
                                    '<div class="housing_buttons"><button class="next_house btn btn-primary">Sonraki Konut</button></div>'
                                )
                            }


                        }

                        $('.next_house').click(function() {
                            var nextHousing = true;
                            $('.tab-pane.active input[required="required"]').map((key, item) => {
                                if (!$(item).val() && $(item).attr('type') != "file") {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })
                            $('.tab-pane.active select[required="required"]').map((key, item) => {
                                if (!$(item).val() || $(item).val() == "Seçiniz") {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })


                            $('.tab-pane.active input[type="file"]').map((key, item) => {
                                if ($(item).parent('div').find('.project_imaget').length == 0) {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })

                            var indexItem = $('.tab-pane.active').index();
                            if (nextHousing) {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                $('.item-left-area p').removeClass('active');
                                $('.item-left-area').eq(indexItem + 1).find('p').addClass('active');
                            } else {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                            }
                        })


                        $('.prev_house').click(function() {

                            var indexItem = $('.tab-pane.active').index();
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                        })

                        function getOldData(roomOrder, inputName) {
                            for (var q = 0; q < oldData.length; q++) {
                                if (oldData[q].room_order == roomOrder && oldData[q].name == inputName) {
                                    return oldData[q].value;
                                }
                            }
                        }
                        for (let i = {{$roomOrder}}; i < {{$roomOrder + 1}}; i++) {
                            for (var j = 0; j < formInputs.length; j++) {
                                if (formInputs[j].type == "number" || formInputs[j].type == "text") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (getOldData(i, inputName) != undefined) {
                                        $($('input[name="' + formInputs[j].name + '"]')).val(getOldData(
                                            i, inputName));
                                    }
                                } else if (formInputs[j].type == "select") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    $($('select[name="' + formInputs[j].name + '"]')).children('option')
                                        .map((key, item) => {
                                            console.log(getOldData(i, inputName));
                                            if (getOldData(i, inputName) != undefined) {
                                                if ($(item).attr("value") == getOldData(i, inputName)) {
                                                    $(item).attr('selected', 'selected')
                                                } else {
                                                    $(item).removeAttr('selected')
                                                }
                                            } else {
                                                $(item).removeAttr('selected')
                                            }

                                        });
                                } else if (formInputs[j].type == 'checkbox-group') {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    var checkboxName = inputName;
                                    checkboxName = checkboxName.split('[]');
                                    checkboxName = checkboxName[0];
                                    $($('input[name="' + inputNamex[0] + [i] + '[][]"]')).map((key, item) => {
                                        console.log(getOldData(i, inputName), inputName)
                                        if (getOldData(i, inputName)) {
                                            JSON.parse(getOldData(i, inputName)).map((checkbox) => {
                                                console.log(checkbox);
                                                if ($(item).attr("value").trim() ==
                                                    "taksitli") {
                                                    if ($(item).attr("value") != undefined &&
                                                        checkbox == $(item).attr("value")
                                                        .trim()) {
                                                        $(item).closest('.tab-pane').find(
                                                            'second-payment-plan').closest(
                                                            'div').removeClass('d-none')
                                                        $(item).attr('checked', 'checked')
                                                    } else {
                                                        $(item).closest('.tab-pane').find(
                                                            'second-payment-plan').closest(
                                                            'div').addClass('d-none')
                                                    }
                                                } else {
                                                    if ($(item).attr("value") != undefined &&
                                                        checkbox == $(item).attr("value")
                                                        .trim()) {
                                                        $(item).attr('checked', 'checked')
                                                    }
                                                }
                                            })
                                        }
                                    });
                                } else if (formInputs[j].type == 'file') {
                                    console.log("file");
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (getOldData(i, inputName) != undefined) {
                                        $($('input[name="' + formInputs[j].name + '"]')).parent('div')
                                            .append(
                                                '<div class="project_imaget"><img src="{{ URL::to('/') }}/project_housing_images/' +
                                                getOldData(i, inputName) + '"></div>');
                                    }
                                }

                            }
                        }
                        console.log($('.dropzonearea'))
                        $('.dropzonearea').closest('.formbuilder-file').remove();
                        for (let i = 1; i <= houseCount; i++) {
                            var images = '';
                            if (oldData.images) {
                                housingImages = JSON.parse(oldData.images[i - 1]);
                            } else {
                                housingImages = [];
                            }
                            for (let j = 0; j < housingImages.length; j++) {
                                images +=
                                    '<div class="project_images_area"><img class="edit_project_housing_image" src="{{ URL::to('/') . '/project_images/' }}' +
                                    housingImages[j] + '"> <span order="' + j + '" housing_order="' + i +
                                    '" class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                            }
                            $('.dropzone2').eq(i - 1).parent('div').append(
                                '<div class="d-none"><input housing_order="' + i +
                                '" type="file" class="new_file_on_drop"></div>')
                            $('.dropzone2').eq(i - 1).html(images);
                        }

                        var csrfToken = "{{ csrf_token() }}";

                        $('.add-new-project-house-image').click(function() {
                            $(this).parent('div').find('.new_file_on_drop').trigger("click")
                        })

                        $('.new_project_housing_image').click(function() {
                            console.log("asd");
                        })

                        $('.item-left-area').click(function(e) {
                            var clickIndex = $(this).index();
                            var currentIndex = $('.nav-linkx.active').closest('.item-left-area')
                                .index();

                            if (clickIndex > currentIndex) {
                                var nextHousing = true;
                                $('.tab-pane.active input[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                $('.tab-pane.active select[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })
                                if ($('.tab-pane.active input[required="required"]').val() == "") {
                                    nextHousing = false;
                                    $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                }

                                $('.tab-pane.active input[type="file"]').map((key, item) => {
                                    if ($(item).parent('div').find('.project_imaget').length ==
                                        0) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                var indexItem = $('.tab-pane.active').index();
                                if (nextHousing) {
                                    $('.tab-pane.active').removeClass('active');
                                    $('.tab-pane').eq(indexItem + 1).addClass('active');
                                    $('.item-left-area p').removeClass('active')
                                    $(this).children('p').addClass('active');
                                } else {
                                    $('html, body').animate({
                                        scrollTop: $('.tab-pane.active').offset().top -
                                            parseFloat($('.navbar-top').css('height'))
                                    }, 100);
                                }



                            } else {

                                $('.item-left-area p').removeClass('active')
                                $(this).children('p').addClass('active');
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(clickIndex).addClass('active');
                            }

                        })

                        $('.tab-pane select[multiple="false"]').removeAttr('multiple')
                        $('input[value="taksitli"]').change(function() {
                            if ($(this).is(':checked')) {
                                $('.second-payment-plan').closest('div').removeClass('d-none');
                            } else {
                                $('.second-payment-plan').closest('div').addClass('d-none');
                            }
                        })

                        $('.copy-item').change(function() {
                            var transactionIndex = 0;
                            $('.tab-pane').prepend(
                                '<div class="loading-icon-right"><i class="fa fa-spinner"></i></div>'
                            );
                            var order = parseInt($(this).val()) - 1;
                            var currentOrder = parseInt($(this).closest('.item-left-area').index());
                            var arrayValues = {};
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    arrayValues[json[lm].name.replace("[]", "").replace("[]", "") + (
                                        currentOrder + 1)] = [];
                                    for (var i = 0; i < json[lm].values.length; i++) {
                                        var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                '')) + (order + 1) + '[][]"][value="' + json[lm]
                                            .values[i].value + '"]' + '').is(':checked')
                                        if (isChecked) {
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', true)

                                            arrayValues[json[lm].name.replace("[]", "").replace("[]",
                                                "") + (currentOrder + 1)].push(json[lm].values[i]
                                                .value)
                                        } else {
                                            transactionIndex++;
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', false)
                                        }
                                    }
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', JSON.stringify(arrayValues));
                                    formData.append('order', currentOrder);
                                    formData.append('key', json[lm].name.replace("[]", "").replace("[]",
                                        "") + (currentOrder + 1));
                                    formData.append('item_type', 3);
                                    formData.append('checkbox', "1");
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.temp.order.copy.checkbox') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }

                                            transactionIndex++;
                                        },
                                    });
                                } else if (json[lm].type == "select") {
                                    var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                        .val();
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option').removeAttr('selected')
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option[value="' + value + '"]').prop('selected',
                                            true);
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('value', value);
                                    formData.append('order', currentOrder);
                                    formData.append('key', json[lm].name.replace("[]", "").replace("[]",
                                        ""));
                                    formData.append('item_type', 3);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }
                                            transactionIndex++;
                                        },
                                    });

                                } else if (json[lm].type == "file" && json[lm].name == "image[]") {

                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append('lastorder', order);
                                    formData.append('order', currentOrder);
                                    formData.append('item_type', 3);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('institutional.copy.item.image') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if (transactionIndex + 1 == json.length) {
                                                $('.loading-icon-right').remove();
                                            }
                                            transactionIndex++;
                                        },
                                    });
                                    var cloneImage = $('.tab-pane').eq(order).find('.project_imaget')
                                        .clone();
                                    $('.tab-pane.active').find('.cover-image-by-housing-type').parent(
                                        'div').find('.project_imaget').remove();
                                    $('.tab-pane.active').find('.cover-image-by-housing-type').parent(
                                        'div').append(cloneImage)
                                } else if (json[lm].type != "file") {
                                    if (json[lm].name) {
                                        var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                            .val();
                                        var formData = new FormData();
                                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                                        formData.append('_token', csrfToken);
                                        formData.append('value', value);
                                        formData.append('order', currentOrder);
                                        formData.append('key', json[lm].name.replace("[]", "").replace(
                                            "[]", ""));
                                        formData.append('item_type', 3);
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                            data: formData,
                                            processData: false,
                                            contentType: false,
                                            success: function(response) {
                                                if (transactionIndex + 1 == json.length) {
                                                    $('.loading-icon-right').remove();
                                                }
                                                transactionIndex++;
                                            },
                                        });

                                        $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                            value);
                                    }

                                }
                            }
                            console.log(transactionIndex);
                        })

                        $('.rendered-form input[type="file"]').removeAttr('required')
                        console.log( $('.rendered-form input[type="file"]'));
                        $('.rendered-form input[type="file"]').closest('.formbuilder-file').find('.formbuilder-file-label').find('.formbuilder-required').remove()

                        $('.rendered-form input').change(function() {
                            if ($(this).attr('type') != "file") {
                                if($(this).hasClass('only-one')){
                                    $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                }

                            }
                        })

                        $('.rendered-form select').change(function() {
                            if ($(this).val()) {
                                $(this).removeClass('error-border')
                            }
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value', $(this).val());
                            console.log($(this).closest('.tab-pane').attr('id'))
                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                .replace('TabContent', "")) - 1);
                            formData.append('key', $(this).attr('name').replace("[]", ""));
                            formData.append('item_type', 3);
                            $.ajax({
                                type: "POST",
                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {},
                            });

                        })

                        $('.price-only').keyup(function() {
                            $('.price-only .error-text').remove();
                            if ($('.price-only').val() != parseFloat($('.price-only').val())) {
                                if ($('.price-only').closest('.form-group').find('.error-text').length >
                                    0) {
                                    $('.price-only').val("");
                                } else {
                                    $(this).closest('.form-group').append(
                                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                    )
                                    $('.price-only').val("");
                                }

                            } else {
                                $(this).closest('.form-group').find('.error-text').remove();
                            }
                        })

                        $('.number-only').keyup(function() {
                            $('.number-only .error-text').remove();
                            if ($(this).val() != parseInt($(this).val())) {
                                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                    $(this).val("");
                                } else {
                                    $(this).closest('.form-group').append(
                                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                    )
                                    $(this).val("");
                                }

                            } else {
                                $(this).closest('.form-group').find('.error-text').remove();
                            }
                        })

                        $('.formbuilder-text input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })

                        $('.formbuilder-number input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })


                        $('.cover-image-by-housing-type').change(function() {
                            var input = this;
                            if (input.files && input.files[0]) {
                                $(this).removeClass('error-border');
                                var reader = new FileReader();

                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('file', this.files[0]);
                                formData.append('order', $(this).closest('.tab-pane').index());
                                formData.append('item_type', 3);
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('institutional.temp.order.project.add.image') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {},
                                    error: function() {
                                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                                        alert("Dosya yüklenemedi.");
                                    }
                                });

                                reader.onload = function(e) {
                                    // Resmi görüntülemek için bir div oluşturun
                                    var imageDiv = $('<div class="project_imaget"></div>');

                                    // Resmi oluşturun ve div içine ekleyin
                                    var image = $('<img>').attr('src', e.target.result);
                                    imageDiv.append(image);
                                    $('.tab-pane.active .cover-image-by-housing-type').closest(
                                            '.formbuilder-file').find('.project_imaget').eq(0)
                                        .remove()
                                    $('.tab-pane.active .cover-image-by-housing-type').closest(
                                        '.formbuilder-file').append(imageDiv)
                                };

                                // Resmi okuyun
                                reader.readAsDataURL(input.files[0]);

                            }
                        })



                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            }

        }
    </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
@endsection
