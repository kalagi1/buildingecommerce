@extends('client.layouts.masterPanel')

@section('content')

    <section>
        <div class="single homes-content details mb-30">
          
            <div class="container">
                  <!-- title -->
            <h5 class="mb-4 header-title">
                @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                    Portföylerim
                @else
                    Koleksiyonlarım
                @endif

                ({{ count($collections) }})
            </h5>
                <div class="collections">
                    @foreach ($collections as $collection)
                        <div class="collection">
                            <div class="collection-head">
                                <div> {{ $collection->name }} Koleksiyonu</div>
                                <ul class="collection-actions">
                                    <li> <button>
                                            <span class="copyLinkButton"
                                                data-url="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug(Auth::user()->name), 'userid' => Auth::user()->id, 'id' => $collection->id]) }}"
                                                style="color: green">
                                                <i class="fa fa-share-alt"></i><span class="copyLinkSuccessMessage">
                                                    Paylaş</span>
                                            </span>
                                        </button></li>
                                    <li>
                                        <div style="margin-left: 10px">
                                            <span data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                                aria-expanded="true" data-bs-reference="parent"
                                                style="margin: 10px;cursor:pointer">
                                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                            </span>
                                            <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#silModal{{ $collection->id }}">
                                                        @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                            Portföyü
                                                        @else
                                                            Koleksiyonu
                                                        @endif Sil
                                                    </a>
                                                </li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editCollectionModal{{ $collection->id }}">
                                                        @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                            Portföy
                                                        @else
                                                            Koleksiyon
                                                        @endif
                                                        Adını Düzenle
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                            @if (count($collection->links))
                                <div class="collection-content">
                                    <div class="collection-images">
                                        @foreach ($collection->links->take(4) as $link)
                                            @php
                                                $projectFirstImage = null;
                                                if ($link->item_type == 1) {
                                                    $data = $link->projectHousingData(
                                                        $link->project->id,
                                                        $link->room_order,
                                                    );
                                                    foreach ($data as $key => $value) {
                                                        if (isset($value['name']) && $value['name'] == 'image[]') {
                                                            $projectFirstImage = $value['value'];
                                                        }
                                                    }
                                                }
                                            @endphp


                                            <img src="{{ $link->item_type == 1 ? URL::to('/') . '/project_housing_images/' . $projectFirstImage : URL::to('/') . '/housing_images/' . json_decode($link->housing->housing_type_data)->image }}"
                                                alt="product-image">
                                        @endforeach
                                    </div>

                                    <div class="collection-navigation">
                                        <div class="collection-stats">
                                            <span class="collection-show-count"><i class="fa fa-eye"></i>
                                                {{ count($collection->clicks) }}</span>
                                        </div><a
                                            href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug($store->name), 'userid' => $store->id, 'id' => $collection->id]) }}"><span>Koleksiyona
                                                Git</span><br>({{ count($collection->links) }} İlan)</a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-collections-box"><svg width="32" height="32" viewBox="0 0 32 32"
                                        fill="e54242" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="32" height="32" fill="#e54242"></rect>
                                        <g id="Add Collections-00 (Default)" clip-path="url(#clip0_1750_971)">
                                            <rect width="1440" height="1577" transform="translate(-1100 -1183)"
                                                fill="white"></rect>
                                            <g id="Group 6131">
                                                <g id="Frame 21409">
                                                    <g id="Group 6385">
                                                        <rect id="Rectangle 4168" x="-8" y="-8" width="228"
                                                            height="48" rx="8" fill="#ea2a28"></rect>
                                                        <g id="Group 2664">
                                                            <rect id="Rectangle 316" width="32" height="32"
                                                                rx="4" fill="#ea2a28"></rect>
                                                            <g id="Group 72">
                                                                <path id="Rectangle 12"
                                                                    d="M16.7099 17.2557L16 16.5401L15.2901 17.2557L12 20.5721L12 12C12 10.8954 12.8954 10 14 10H18C19.1046 10 20 10.8954 20 12V20.5721L16.7099 17.2557Z"
                                                                    fill="white" stroke="white" stroke-width="2"></path>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1750_971">
                                                <rect width="1440" height="1577" fill="white"
                                                    transform="translate(-1100 -1183)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <h1>Koleksiyon Ürünlerin Yok</h1><span class="empty-message">Koleksiyonları takip
                                        edebilir, sevdiklerinizle paylaşabilirsiniz!</span><button
                                        class="add-button-wrapper"><i class="i-plus-bold"></i><span
                                            class="add-button-text">Koleksiyona Ürün Ekle</span></button>
                                </div>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row list" id="icon-list">
                @if (count($collections) > 0)
                    @foreach ($collections as $collection)
                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                            <div class="border rounded-2 px-3 text-center bg-body-emphasis dark__bg-gray-1000 shadow-sm">
                                <div class="card-header border-bottom bg-white mb-3"
                                    style="display: flex;
                                justify-content: space-between;
                                padding: 5px;
                                align-items: center;">
                                    <strong style="font-size: 11px;text-align:left">
                                        <span style="color:#e54242"><i class="fa fa-eye"></i>
                                            {{ count($collection->clicks) }} Görüntülenme</span>
                                    </strong>

                                    <div class="col-auto" style="display: flex;align-items:center">
                                        <div>
                                            <button class="btn btn-sm" style="padding:0;background-color:white !important"
                                                type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                aria-haspopup="true" aria-expanded="true" data-bs-reference="parent">
                                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end"
                                                data-popper-placement="bottom-end">
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#silModal{{ $collection->id }}">
                                                        @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                            Portföyü
                                                        @else
                                                            Koleksiyonu
                                                        @endif Sil
                                                    </a>
                                                </li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editCollectionModal{{ $collection->id }}">
                                                        @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                            Portföy
                                                        @else
                                                            Koleksiyon
                                                        @endif
                                                        Adını Düzenle
                                                    </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                                <!-- Silme Modalı -->
                                <div class="modal fade" id="silModal{{ $collection->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="silModalLabel{{ $collection->id }}">Silme
                                                    İşlemini Onayla</h5>
                                                <button class="btn p-1" type="button" data-bs-dismiss="modal"
                                                    aria-label="Kapat">
                                                    <span class="fas fa-times fs-9"></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="text-body-tertiary lh-lg mb-0">Bu koleksiyonu silmek
                                                    istediğinizden emin misiniz?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="{{ route('institutional.collection.delete', ['id' => $collection->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-primary" type="submit">Sil</button>
                                                    <button class="btn btn-outline-primary" type="button"
                                                        data-bs-dismiss="modal">İptal</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="modal fade" id="editCollectionModal{{ $collection->id }}" tabindex="-1"
                                    aria-labelledby="editCollectionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCollectionModalLabel">Düzenle</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('institutional.collection.edit', ['id' => $collection->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="collectionName" class="form-label">
                                                            @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                                Portföy Adı:
                                                            @else
                                                                Koleksiyon Adı:
                                                            @endif
                                                        </label>
                                                        <input type="text" class="form-control" id="collectionName"
                                                            name="collectionName" value="{{ $collection->name }}"
                                                            required>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-7">
                                        <div class="d-flex align-items-center mb-2">

                                            <p class="fw-bold mb-0 lh-1" style="font-size: 12px !important">
                                                @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                                    Portföy Adı:
                                                @else
                                                    Koleksiyon Adı:
                                                @endif <span
                                                    class="fw-semibold text-primary ms-1">{{ $collection->name }}</span>
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center mb-2 mt-3">

                                            <p class="fw-bold mb-0 lh-1" style="font-size: 12px !important">İlan
                                                Sayısı :
                                                <span class="fw-semibold text-primary ms-1">
                                                    {{ count($collection->links) }} İlan</span>
                                            </p>
                                        </div>
                                        @if (Auth::check() && Auth::user()->type != '1' && Auth::user()->type != '3')
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="fw-bold mb-0 lh-1"
                                                    style="font-size: 12px !important; margin-right: 10px;">
                                                    Mağazamda paylaş
                                                </p>
                                                <div class="form-switch text-center pb-0 mb-0" style="height: 15px">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="brandToggle_{{ $collection->id }}"
                                                        {{ $collection->status == 1 ? 'checked' : '' }}
                                                        onchange="toggleBrandStatus({{ $collection->id }}, this)" />
                                                </div>
                                            </div>
                                        @endif



                                    </div>
                                    <div class="col-md-5 p-0 m-0">
                                        <div class="col-md-12">
                                            <a href="{{ route('institutional.sharer.links.index', ['id' => $collection->id]) }}"
                                                class="text-decoration-none">
                                                <button style="width:100%;font-size:10px;padding:8px 0"
                                                    class="badge badge-phoenix fs-10 badge-phoenix-warning"
                                                    type="button">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i> DÜZENLE
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-12">
                                            <a href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug(Auth::user()->name), 'userid' => Auth::user()->id, 'id' => $collection->id]) }}"
                                                class="text-decoration-none" target="_blank" style="width: 100%">

                                                <button style="width:100%;font-size:10px;padding:8px 0"
                                                    class="badge badge-phoenix fs-10 badge-phoenix-info" type="button">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> ÖNİZLE
                                                </button>
                                            </a>
                                        </div>
                                        <div class="col-md-12">
                                            <button class="badge badge-phoenix fs-10 badge-phoenix-success"
                                                style="width:100%;font-size:10px;padding:8px 0" type="button"
                                                onclick="copyLink('{{ route('sharer.links.showClientLinks', ['slug' => Str::slug(Auth::user()->name), 'userid' => Auth::user()->id, 'id' => $collection->id]) }}')">
                                                <i class="fa fa-copy" aria-hidden="true"></i> LİNKİ KOPYALA
                                            </button>

                                        </div>
                                        <div class="col-md-12">
                                            <button class="badge badge-phoenix fs-10 badge-phoenix-success"
                                                style="width:100%;font-size:10px;padding:8px 0" type="button"
                                                onclick="copyLinkAndShare('{{ route('sharer.links.showClientLinks', ['slug' => Str::slug(Auth::user()->name), 'userid' => Auth::user()->id, 'id' => $collection->id]) }}')">
                                                <i class="fa fa-whatsapp" aria-hidden="true"></i> WHATSAPPTA PAYLAŞ
                                            </button>
                                        </div>

                                        <!-- Add this script at the end of your HTML body or after Bootstrap's JavaScript files -->
                                        <script>
                                            function copyLinkAndShare(link) {
                                                window.location.href = "whatsapp://send?text=" + encodeURIComponent(link);
                                            }
                                        </script>




                                    </div>

                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row justify-content-center align-items-center">
                        <div class="col-12 col-lg-6 text-center order-lg-1"><img class="img-fluid w-lg-100 d-dark-none"
                                src="{{ asset('images/emlak-kulup-banner.png') }}" alt="" width="400"><img
                                class="img-fluid w-md-50 w-lg-100 d-light-none"
                                src="{{ asset('images/emlak-kulup-banner.png') }}" alt="" width="540">
                        </div>
                        <div class="col-12 col-lg-6 text-center text-lg-start">
                            <h2 class="text-body-secondary fw-bolder mb-3 text-black">Takipçilerine ilham ver! Doğru
                                evi bulmalarına aracı ol!</h2>
                            <p class="text-body mb-5">Sosyal medya hesaplarının ne kadar popüler olduğu fark
                                etmeksizin paylaşımlarında hepsini değerlendir, satış nereden gelir bilinmez! </p><a
                                class="btn btn-lg btn-primary" href="{{ url('/') }}">Paylaş Kazan</a>
                        </div>
                    </div>
                @endif






            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

    <script>
        $(".copyLinkButton").click(function() {
            var url = $(this).data("url");
            var tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            $(this).children(".copyLinkSuccessMessage").html("Panoya Kopyalandı");

        });

        function toggleBrandStatus(collectionID, element) {
            const status = element.checked ? 1 : 0;

            $.ajax({
                type: 'POST',
                url: '{{ route('update.collection.status') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    collectionID: collectionID,
                    status: status
                },
                success: function(response) {
                    console.log(response);

                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection


@section('styles')
    <style>
        @media (max-width:768px) {

            #icon-list div {
                margin-bottom: 10px
            }
        }

        .border {
            border: 1px solid #dee2e6 !important;
        }

        .homes-content .row {
            width: 100% !important;
            margin: 0 auto;
        }

        .header-title {
            border-bottom: 2px solid #EA2B2E !important;
            color: black;
            margin: 0;
            padding: 10px;
        }

        <style>.slick-track {
            margin: 0 !important;
        }

        .section-title h2 {
            color: black !important
        }

        .section-title:before {
            background-color: black !important
        }

        .copyLinkSuccessMessage {
            font-size: 11px
        }

        .bannerResize,
        .bannerResizeGrid {
            padding: 0 !important;
        }

        .projectMobileMargin {
            margin-bottom: 20px !important;
        }

        @media (max-width: 768px) {

            .bannerResize,
            .bannerResizeGrid {
                padding: 0 !important;
            }

            .section-title {
                margin-bottom: 20px !important;
                padding-bottom: 0 !important;
            }

            .circleIcon {
                font-size: 5px;
                color: #e54242;
                padding-right: 5px
            }

            .priceFont {
                font-weight: 600;
                font-size: 11px;
            }
        }

        .collections {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            margin: 0 auto;
            justify-content: space-between;
        }

        .collection {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border: 1px solid #e6e6e6;
            width: calc(50% - 10px);
            margin-bottom: 20px;
            box-sizing: border-box;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.05);
        }

        .collection-head {
            display: flex;
            justify-content: space-between;
            color: #333;
            border-bottom: 1px solid #e6e6e6;
            font-size: 16px;
            padding: 12px 15px;
            height: 44px;
            box-sizing: border-box;
        }

        .collection-head div,
        .collection-head a {
            display: flex;
            align-items: center;
            font-size: 11px;
            font-weight: 600;
            flex: 1;
            width: calc(100% - 100px);
        }

        .collection-owner {
            border-radius: 50%;
            width: 24px;
            height: 24px;
            margin-right: 10px;
        }

        .collection-head a span.label.with-image {
            width: calc(100% - 44px);
        }

        .collection-head div span.label,
        .collection-head a span.label {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            width: calc(100% - 10px);
        }

        .collection-head .collection-actions {
            display: flex;
            align-items: center;
            margin-bottom: 0 !important;
        }

        .collection-head button i {
            margin-right: 5px
        }

        .collection-head button {
            display: flex;
            align-items: center;
            background-color: transparent;
            color: black;
            font-size: 12px;
            border: none;
            padding: 0;
            cursor: pointer;
            transition: all 0.3s ease-out;
        }

        .collection-images img {
            border: 1px solid #e6e6e6;
            border-radius: 4px;
            width: 50px;
            height: 64px;
            margin-right: 10px;
            object-fit: cover;
        }

        .collection-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }

        .collection-content .collection-images {
            display: flex;
        }

        .collection-content .collection-navigation {
            display: flex;
            flex-direction: column;
        }

        .empty-collections-box {
            text-align: center;
            padding: 20px
        }

        .empty-collections-box h1 {
            font-size: 12px;
            margin-top: 10px;
            margin-bottom: 0
        }

        .empty-collections-box svg {
            border-radius: 50px
        }

        .add-button-wrapper {
            display: flex;
            align-items: center;
            padding: 0;
            width: 150px;
            height: 30px;
            font-weight: 700;
            border-radius: 6px !important;
            background-color: #ffd0d0;
            border: none;
            cursor: pointer;
            justify-content: center;
            margin: 0 auto;
            margin-top: 10px;
            color: #EA2B2E !important;

        }

        .collection-stats {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 10px;
            font-size: 12px;
            color: #666666;
            font-weight: 600;
            line-height: 15px;
            letter-spacing: 0;
            text-align: center;
            padding-right: 10px;
        }

        .collection-stats .spacer {
            background: #999999;
            opacity: 0.3;
            width: 1px;
            height: 10px;
            display: inline-block;
            margin: 0 7px;
        }

        .collection-stats i {
            margin-right: 6px;
            font-size: 9px;
        }

        .collection-content a {
            color: #EA2B2E;
            text-align: center;
            padding: 10px 0;
            transition: all 0.3s ease-out;
        }

        .collection-show-count {
            color: black;
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    </style>
@endsection
