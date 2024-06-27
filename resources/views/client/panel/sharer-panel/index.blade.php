@extends('client.layouts.masterPanel')

@section('content')

<section>
    <div>
        <div class="single homes-content details mb-30">
            <!-- title -->
            <h5 class="mb-4">Property Details</h5>
            <ul class="homes-list clearfix">
                <li>
                    <span class="font-weight-bold mr-1">Property ID:</span>
                    <span class="det">V254680</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Property Type:</span>
                    <span class="det">House</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Property status:</span>
                    <span class="det">For Sale</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Property Price:</span>
                    <span class="det">$230,000</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Rooms:</span>
                    <span class="det">6</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Bedrooms:</span>
                    <span class="det">7</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Bath:</span>
                    <span class="det">4</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Garages:</span>
                    <span class="det">2</span>
                </li>
                <li>
                    <span class="font-weight-bold mr-1">Year Built:</span>
                    <span class="det">10/6/2020</span>
                </li>
            </ul>
            <!-- title -->
            <h5 class="mt-5">Amenities</h5>
            <!-- cars List -->
            <ul class="homes-list clearfix">
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Air Cond</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Balcony</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Internet</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Dishwasher</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Bedding</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Cable TV</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Parking</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Pool</span>
                </li>
                <li>
                    <i class="fa fa-check-square" aria-hidden="true"></i>
                    <span>Fridge</span>
                </li>
            </ul>
        </div>
    </div>
</section>
    <div class="content">
        <div class="card border mb-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">
            <div class="card-header border-bottom">
                <div class="row flex-between-center g-2">
                    <div class="col-auto">
                        <h4 class="mb-0">
                            @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                                Portföylerim
                            @else
                                Koleksiyonlarım
                            @endif
                        </h4>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row list" id="icon-list">
                    @if (count($collections) > 0)
                        @foreach ($collections as $collection)
                            <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                                <div
                                    class="border rounded-2 px-3 text-center bg-body-emphasis dark__bg-gray-1000 shadow-sm">
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
                                                <button class="btn btn-sm" style="padding:0" type="button"
                                                    data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                                    aria-expanded="true" data-bs-reference="parent">
                                                    <svg class="svg-inline--fa fa-ellipsis" style="transform:rotate(90deg)"
                                                        data-fa-transform="shrink-2" aria-hidden="true" focusable="false"
                                                        data-prefix="fas" data-icon="ellipsis" role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                                        data-fa-i2svg="" style="transform-origin: 0.4375em 0.5em;">
                                                        <g transform="translate(224 256)">
                                                            <g
                                                                transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                                <path fill="currentColor"
                                                                    d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"
                                                                    transform="translate(-224 -256)"></path>
                                                            </g>
                                                        </g>
                                                    </svg></button>
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

                                                    <p class="fw-bold mb-0 lh-1" style="font-size: 12px !important">
                                                        Mağazamda paylaş
                                                        <span style="margin-left:5px">
                                                            <div
                                                                class="form-check form-switch text-center d-block pb-0 mb-0">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="brandToggle_{{ $collection->id }}"
                                                                    {{ $collection->status == 1 ? 'checked' : '' }}
                                                                    onchange="toggleBrandStatus({{ $collection->id }}, this)" />
                                                            </div>
                                                        </span>
                                                    </p>


                                                </div>
                                            @endif


                                        </div>
                                        <div class="col-md-5">
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
                                                        class="badge badge-phoenix fs-10 badge-phoenix-info"
                                                        type="button">
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

                                                function copyLink(text) {
                                                    var textArea = document.createElement("textarea");
                                                    textArea.value = text;
                                                    document.body.appendChild(textArea);
                                                    textArea.select();
                                                    document.execCommand('copy');
                                                    document.body.removeChild(textArea);
                                                }
                                            </script>




                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-lg-6 text-center order-lg-1"><img
                                    class="img-fluid w-lg-100 d-dark-none"
                                    src="{{ asset('images/emlak-kulup-banner.png') }}" alt=""
                                    width="400"><img class="img-fluid w-md-50 w-lg-100 d-light-none"
                                    src="{{ asset('images/emlak-kulup-banner.png') }}" alt=""
                                    width="540"></div>
                            <div class="col-12 col-lg-6 text-center text-lg-start">
                                <h2 class="text-body-secondary fw-bolder mb-3 text-black">Takipçilerine ilham ver! Doğru evi bulmalarına aracı ol!</h2>
                                <p class="text-body mb-5">Sosyal medya hesaplarının ne kadar popüler olduğu fark
                                    etmeksizin paylaşımlarında hepsini değerlendir, satış nereden gelir bilinmez! </p><a
                                    class="btn btn-lg btn-primary" href="{{url('/')}}">Paylaş Kazan</a>
                            </div>
                        </div>
                    @endif






                </div>
            </div>
        </div>
    </div>


    <script>
        function copyLink(link) {
            var tempInput = document.createElement('input');
            tempInput.value = link;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert("Kopyalandı");
        }

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
                    if (response.success) {
                        $(element).closest('.brand-item').attr('data-is-show', isShow);
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }
    </script>
@endsection


@section('css')
    <style>
        @media (max-width:768px) {

            #icon-list div {
                margin-bottom: 10px
            }
        }
    </style>
@endsection
