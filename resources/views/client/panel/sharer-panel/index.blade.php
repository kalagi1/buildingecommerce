@extends('client.layouts.master')

@section('content')

    <section>
            <div class="single homes-content details mb-30">
                <!-- title -->
                <h5 class="mb-4 header-title">
                    @if (Auth::user()->corporate_type == 'Emlak Ofisi')
                        Portföylerim
                    @else
                        Koleksiyonlarım
                    @endif
                </h5>
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
                                                <button class="btn btn-sm"
                                                    style="padding:0;background-color:white !important" type="button"
                                                    data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true"
                                                    aria-expanded="true" data-bs-reference="parent">
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

        .header-title{
            border-bottom: 1px solid #ddd;
    background: #ea2a28 !important;
    color: white;
    margin: 0;
    padding: 10px;
        }
    </style>
@endsection
