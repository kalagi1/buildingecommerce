<div>
    <div class="container">

        <div class="watermark"></div>

        <div class="row mb-3" style="align-items: center">
            <div class="col-md-8">
                <div class="headings-2 pt-0">
                    <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                        <div class="detail-wrapper-body">
                            <div class="listing-title-bar pb-3 pt-3">

                                <h3>
                                    {{ isset($projectData) && isset($projectData['project_title']) ? $projectData['project_title'] : '' }}

                                </h3>

                            </div>
                            <div class="mobile-action"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="headings-2 pt-0 move-gain">
                    <div class="gainStyle" style="width: 100%; justify-content: center;align-items:center;display:flex">



                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-8 blog-pots">
                <div class="row">
                    <div class="col-md-12">

                        <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                            <div class="button-effect-div favorite-move">
                                <div class="button-effect toggle-favorite" data-housing-id="270">
                                    <i class="fa fa-heart-o"></i>
                                </div>
                            </div>
                            <div class="carousel-inner">
                                <div class="item carousel-item active" data-slide-number="0">
                                    <a href="{{ $projectData['cover_image_imagex'] }}" data-lightbox="project-images">
                                        <img src="{{ $projectData['cover_image_imagex'] }}" class="img-fluid"
                                            alt="Kapak Fotoğrafı">
                                    </a>
                                </div>

                                @foreach ($projectData['gallery_imagesx'] as $index => $image)
                                    <div class="item carousel-item" data-slide-number="{{ $index + 1 }}">
                                        <a href="{{ $image }}" data-lightbox="project-images">
                                            <img src="{{ $image }}" class="img-fluid" alt="Galeri Görseli">
                                        </a>
                                    </div>
                                @endforeach
                            </div>



                            <div class="listingDetailsSliderNav mt-3 d-flex">
                                {{-- Kapak Görseli --}}
                                <div class="item active" style="margin: 10px; cursor: pointer">
                                    <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                        <img src="{{ $projectData['cover_image_imagex'] }}"
                                            class="img-fluid carousel-indicator-image" alt="listing-small">
                                    </a>
                                </div>
                                {{-- Diğer Görseller --}}
                                @foreach ($projectData['gallery_imagesx'] as $index => $image)
                                    <div class="item" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-{{ $index + 1 }}"
                                            data-slide-to="{{ $index + 1 }}" data-target="#listingDetailsSlider">
                                            <img src="{{ $image }}" class="img-fluid carousel-indicator-image"
                                                alt="listing-small">
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                            <nav aria-label="Page navigation example" style="margin-top: 7px">
                                <ul class="pagination">
                                    <li class="page-item page-item-left"><a class="page-link" href="#"><i
                                                class="fas fa-angle-left"></i></a></li>
                                    <li class="page-item page-item-middle">
                                        <a class="page-link"
                                            href="#">1/{{ isset($projectData['gallery_imagesx']) ? count($projectData['gallery_imagesx']) : 1 }}</a>
                                    </li>

                                    <li class="page-item page-item-right"><a class="page-link" href="#"><i
                                                class="fas fa-angle-right"></i></a></li>
                                </ul>
                            </nav>
                        </div>



                    </div>
                </div>


            </div>
            <aside class="col-md-4  car">
                <div class="single widget">

                    <div class="moveStore">
                        <div class="widget-boxed removeClass mb-5">
                            <div class="widget-boxed-body pt-0">
                                <div class="sidebar-widget author-widget2">
                                    <table class="table">
                                        <tbody>

                                            <tr style="border-top: none !important">
                                                <td style="border-top: none !important">
                                                    <span class="det" style="color: #EA2B2E !important;">
                                                        @if (isset($city) || isset($county) || isset($neighbour))
                                                            @if (isset($city))
                                                                {{ strtoupper($city->title) }}
                                                            @endif
                                                            @if (isset($county))
                                                                / {{ strtoupper($county->ilce_title) }}
                                                            @endif
                                                            @if (isset($neighbour))
                                                                / {{ strtoupper($neighbour->mahalle_title) }}
                                                            @endif
                                                        @else
                                                            Konum bilgisi yok
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span> İlan No :</span>
                                                    <span class="det" style="color:#274abb;">
                                                        {{ isset($newHousingId) ? $newHousingId : '' }}

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span> İlan Tarihi :</span>
                                                    <span class="det" style="color:#274abb;">
                                                        {{ \Carbon\Carbon::now()->locale('tr')->translatedFormat('d F Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>
                                                        @if (isset($user))
                                                            @if ($user->type == '1')
                                                                Sahibinden:
                                                            @else
                                                                Mağaza:
                                                            @endif
                                                        @endif


                                                    </span>
                                                    <span class="det text-wrap" style="color:#274abb;">
                                                        {{ isset($user) ? $user->name : '' }}

                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span> Kimden :</span>
                                                    <span class="det text-wrap" style="color:#274abb;">
                                                        @if (isset($user))
                                                            {{ $user->type == '1' ? 'Bireysel Kullanıcı' : ($user->corporate_type == 'Emlak Ofisi' ? 'Gayrimenkul Ofisi' : $user->corporate_type) }}
                                                        @endif
                                                    </span>

                                                </td>
                                            </tr>

                                            @if (isset($user))
                                                @if ($user->type == '1')
                                                    <tr>
                                                        <td>
                                                            Cep :
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel:{{ isset($user) ? $user->mobile_phone : '' }}">
                                                                    {{ isset($user) ? $user->mobile_phone : '' }}
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>
                                                            İş :
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel: {{ isset($user) ? $user->phone : '' }}">
                                                                    {{ isset($user) ? $user->phone : '' }}
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif

                                            @endif





                                            <tr>
                                                <td>
                                                    İlan Tipi :
                                                    <span class="det">
                                                        {{ isset($housingTypeParent1) ? $housingTypeParent1->title : '' }}

                                                        {{ isset($housingTypeParent2) ? $housingTypeParent2->title : '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    E-Posta :
                                                    <span class="det">
                                                        <a style="text-decoration: none;color:inherit"
                                                            href="mailto:{{ isset($user) ? $user->email : '' }}">
                                                            {{ isset($user) ? $user->email : '' }}</a>
                                                    </span>

                                                </td>
                                            </tr>
                                            @if (isset($projectData['create_company']) && $projectData['create_company'])
                                                <tr>
                                                    <td>
                                                        Yapıcı Firma :
                                                        <span class="det">
                                                            {{ $projectData['create_company'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['island']) && $projectData['island'])
                                                <tr>
                                                    <td>
                                                        Ada :
                                                        <span class="det">
                                                            {{ $projectData['island'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['parcel']) && $projectData['parcel'])
                                                <tr>
                                                    <td>
                                                        Parsel :
                                                        <span class="det">
                                                            {{ $projectData['parcel'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['start_date']) && $projectData['start_date'])
                                                <tr>
                                                    <td>
                                                        Başlangıç Tarihi :
                                                        <span class="det">
                                                            {{ $projectData['start_date'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['end_date']) && $projectData['end_date'])
                                                <tr>
                                                    <td>
                                                        Bitiş Tarihi :
                                                        <span class="det">
                                                            {{ $projectData['end_date'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['total_project_area']) && $projectData['total_project_area'])
                                                <tr>
                                                    <td>
                                                        Toplam Proje Alanı m2 :
                                                        <span class="det">
                                                            {{ $projectData['total_project_area'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td>
                                                    Toplam Konut Sayısı :
                                                    <span class="det">
                                                        {{ isset($roomCount) ? $roomCount : '' }}

                                                    </span>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Satılan Konut Sayısı :
                                                    <span class="det">
                                                        0
                                                    </span>

                                                </td>
                                            </tr>










                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

            </aside>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  active " id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">Projedeki Konutlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false"
                                tabindex="-1">Açıklama</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false"
                                tabindex="-1">Özellikler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#map"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                tabindex="-1">Harita</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                tabindex="-1">Yorumlar</button>
                        </li>


                    </ul>

                    <div class="tab-content inner-pages" id="myTabContent" style="display: block;">

                        <div class="tab-pane properties-right list fade blog-info details mb-30  show active "
                            id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="button-tabs">
                                <ul class="tabs">
                                    @if (isset($blocks) && $haveBlocks)
                                        @foreach ($blocks as $index => $block)
                                            <li class="nav-item-block  @if ($index == 0) active @endif"
                                                role="presentation">
                                                <div class="tab-title">
                                                    <span>{{ $block['name'] }}</span>
                                                </div>
                                            </li>
                                        @endforeach

                                    @endif

                                </ul>
                            </div>

                            @if (isset($blocks) && is_array($blocks) && isset($blocks[0]['rooms']))
                                @php
                                    $limitedRooms = array_slice($blocks[0]['rooms'], 0, $blocks[0]['roomCount']);
                                @endphp
                                @foreach ($limitedRooms as $index => $item)
                                    <div class="row project-filter-reverse blog-pots" id="project-room">
                                        <div class="col-md-12 col-12">
                                            <div class="project-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="#" style="height: 100%">

                                                            <div class="d-flex" style="height: 100%;">
                                                                <div
                                                                    style="background-color: #EA2B2E !important; border-radius: 0px 8px 0px 8px; height:100%">
                                                                    <p
                                                                        style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; text-align:center; ">
                                                                        No<br>

                                                                        {{ $index + 1 }}

                                                                    </p>
                                                                </div>
                                                                <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                    data-aos="fade-up">
                                                                    <div class="button-effect-div">



                                                                        <span
                                                                            class="btn addCollection mobileAddCollection"
                                                                            data-type="project" data-project="283"
                                                                            data-id="1">
                                                                            <i class="fa fa-bookmark-o"></i>
                                                                        </span>


                                                                        <span
                                                                            class="btn toggle-project-favorite bg-white"
                                                                            data-project-housing-id="1"
                                                                            data-project-id="283">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="homes position-relative">
                                                                        <img src="{{ $item['image[]_imagex'] }}"
                                                                            alt="home-1" class="img-responsive"
                                                                            style="height: 100px !important; object-fit: cover">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                        data-aos="fade-up">

                                                        <div
                                                            class="row align-items-center justify-content-between mobile-position">
                                                            <div class="col-md-9">


                                                                <div class="homes-list-div"
                                                                    style="flex-direction: column !important;">


                                                                    <ul class="homes-list clearfix pb-3 d-flex projectCardList"
                                                                        style="height: 90px !important">

                                                                        @foreach (['column1', 'column2', 'column3'] as $column)
                                                                            @php
                                                                                $column_name =
                                                                                    $projectListItems[0]
                                                                                        ->{$column . '_name'} ?? '';
                                                                                $column_additional =
                                                                                    $projectListItems[0]
                                                                                        ->{$column . '_additional'} ??
                                                                                    '';
                                                                                $column_name_exists =
                                                                                    $column_name &&
                                                                                    isset($item[$column_name . '[]']);
                                                                            @endphp

                                                                            @if ($column_name_exists)
                                                                                <li
                                                                                    class="d-flex align-items-center itemCircleFont">
                                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                                        aria-hidden="true"></i>
                                                                                    <span>
                                                                                        {{ $item[$column_name . '[]'] }}
                                                                                        @if ($column_additional && is_numeric($item[$column_name . '[]']))
                                                                                            {{ $column_additional }}
                                                                                        @endif
                                                                                    </span>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach



                                                                        <li
                                                                            class="d-flex align-items-center itemCircleFont">
                                                                            <i class="fa fa-circle circleIcon mr-1"
                                                                                aria-hidden="true"></i>
                                                                            <span>
                                                                                {{ \Carbon\Carbon::now()->locale('tr')->translatedFormat('d F Y') }}
                                                                            </span>
                                                                        </li>

                                                                        <li class="the-icons mobile-hidden">
                                                                            <span style="width:100%;text-align:center">
                                                                                @php
                                                                                    $price = str_replace(
                                                                                        '.',
                                                                                        '',
                                                                                        $item['price[]'],
                                                                                    ); // Remove dots from the price string
                                                                                    $price = intval($price); // Convert the cleaned price string to an integer
                                                                                @endphp
                                                                                @if (isset($item['share_sale[]']) && isset($item['number_of_shares[]']))
                                                                                    <span class="text-center w-100">
                                                                                        1 /
                                                                                        {{ isset($item['number_of_shares[]']) ? $item['number_of_shares[]'] : null }}
                                                                                        Fiyatı
                                                                                    </span>
                                                                                    <h6
                                                                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                                                        {{ number_format($price / (isset($item['number_of_shares[]']) ? $item['number_of_shares[]'] : 1), 2, ',', '.') }}
                                                                                        ₺
                                                                                    </h6>
                                                                                @else
                                                                                    <h6
                                                                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                                                        {{ number_format($price, 2, ',', '.') }}
                                                                                        ₺
                                                                                    </h6>
                                                                                @endif
                                                                            </span>
                                                                        </li>




                                                                    </ul>

                                                                    @if (isset($item['share_sale[]']) && isset($item['number_of_shares[]']))
                                                                        @php
                                                                            $numberOfShares = intval(
                                                                                str_replace(
                                                                                    '.',
                                                                                    '',
                                                                                    $item['number_of_shares[]'],
                                                                                ),
                                                                            ); // Convert the number of shares to an integer
                                                                            $width = 100 / $numberOfShares; // Calculate the width percentage for each share
                                                                        @endphp
                                                                        <div class="bar-chart">
                                                                            <div class="progress"
                                                                                style="border-radius: 0 !important; display: grid; grid-template-columns: repeat({{ $numberOfShares }}, 1fr);">
                                                                                @for ($i = 0; $i < $numberOfShares; $i++)
                                                                                    <div class="progress-bar"
                                                                                        style="width: {{ $width }}%; border-left: {{ $i > 0 ? '1px solid #cbcbcb' : 'none' }};">
                                                                                    </div>
                                                                                @endfor
                                                                            </div>
                                                                        </div>
                                                                    @endif




                                                                </div>

                                                            </div>

                                                            <div class="col-md-3 mobile-hidden"
                                                                style="height: 100%; padding: 0">
                                                                <div class="homes-button"
                                                                    style="width: 100%; height: 100px !important">
                                                                    <button class="first-btn payment-plan-button"
                                                                        project-id="283" data-sold="0"
                                                                        order="1" data-block=""
                                                                        data-payment-order="1">
                                                                        Ödeme Detayı
                                                                    </button>








                                                                    <button class="CartBtn second-btn mobileCBtn"
                                                                        data-type="project" data-project="283"
                                                                        style="height: auto !important" data-id="1"
                                                                        data-share="[&quot;Var&quot;]"
                                                                        data-number-share="12">
                                                                        <span class="IconContainer">
                                                                            <img src="http://127.0.0.1:8000/sc.png"
                                                                                alt="">
                                                                        </span>
                                                                        <span class="text">Sepete Ekle</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                            {{-- <p> {!! isset($projectData) && isset($projectData['description']) ? $projectData['description'] : '' !!}
                            </p>
                            <hr>
                            @if (isset($labels))
                                <div class="similar-property featured portfolio p-0 bg-white">

                                    <div class="single homes-content">
                                        @if (count($labels) > 0)
                                            @foreach ($labels as $label => $val)
                                                @if (is_array($val))
                                                    @if (count($val) > 1)
                                                        @if ($label != 'Galeri')
                                                            <h5>
                                                                {{ $label }}</h5>

                                                            <ul class="homes-list clearfix mb-3 checkSquareIcon">
                                                                @foreach ($val as $item)
                                                                    <li><i class="fa fa-check-square"
                                                                            aria-hidden="true"></i><span>{{ $item }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <div>
                                                <span>Bu ilana ait herhangi bir özellik
                                                    belirtilmemiştir.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>


<style>
    .container {
        position: relative;

    }

    .watermark {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 400;
        background-image: url("/classified_preview_overlay.png");
        -webkit-background-size: 100%;
        -moz-background-size: 100%;
        background-size: 100%;
    }


    .blog-info.details {
        background: #fff;
        padding: 20px
    }

    .table td {
        display: flex !important;
        justify-content: space-between;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
    integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('.listingDetailsSliderNav').slick({
            slidesToShow: 5,
            slidesToScroll: 5,
            dots: false,
            loop: false,
            autoplay: false,
            arrows: false,
            margin: 0,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 993,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                    dots: false,
                    arrows: false
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: false,
                    arrows: false
                }
            }]
        });
    });
</script>
