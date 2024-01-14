@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="card border mb-3" data-list="{&quot;valueNames&quot;:[&quot;icon-list-item&quot;]}">
            <div class="card-header border-bottom bg-body">
                <div class="row flex-between-center g-2">
                    <div class="col-auto">
                        <h4 class="mb-0">Koleksiyonlarım</h4>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row list" id="icon-list">
                    @foreach ($collections as $collection)
                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                            <div class="border rounded-2 px-3 text-center bg-body-emphasis dark__bg-gray-1000 shadow-sm">
                                <div class="card-header border-bottom bg-white mb-3"
                                    style="display: flex;
                                justify-content: space-between;
                                padding: 5px;
                                align-items: center;">
                                    <strong style="font-size: 12px;text-align:left">{{ $collection->name }} <br>
                                        <a href="{{ route('institutional.sharer.viewsLinks.index', $collection->id) }}">
                                            <span style="color:#e54242"><i class="fa fa-eye"></i>
                                                {{ count($collection->clicks) }} Görüntülenme</span></a>
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
                                                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                                                            <path fill="currentColor"
                                                                d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z"
                                                                transform="translate(-224 -256)"></path>
                                                        </g>
                                                    </g>
                                                </svg></button>
                                            <ul class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#silModal{{ $collection->id }}">Koleksiyonu Sil</a>
                                                </li>
                                                <li><a class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editCollectionModal{{ $collection->id }}">Koleksiyon
                                                        Adını Düzenle</a></li>
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



                                <span style="width:100%"><strong>{{ count($collection->links) }} İlan</strong></span><br>
                                <a href="{{ route('institutional.sharer.links.index', ['id' => $collection->id]) }}"
                                    class="text-decoration-none">
                                    <button class="btn" style="color:#EA2B2E;"> Koleksiyona Git</button>
                                </a>
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
                                                        <label for="collectionName" class="form-label">Koleksiyon
                                                            Adı</label>
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
                                    <div class="col-md-6">
                                        <a href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug(Auth::user()->name), 'id' => $collection->id]) }}"
                                            class="text-decoration-none" target="_blank" style="width: 100%">

                                            <button style="width:100%;font-size:10px;padding:3px 0"
                                                class="btn btn-primary me-1 mb-1" type="button">
                                                <i class="fa fa-eye" aria-hidden="true"></i> <br> ÖNİZLEME
                                            </button>
                                        </a>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('sharer.links.showClientLinks', ['slug' => Str::slug(Auth::user()->name), 'id' => $collection->id]) }}"
                                            class="text-decoration-none" target="_blank" style="width: 100%">

                                            <button class="btn btn-secondary me-1 mb-1"
                                                style="width:100%;font-size:10px;padding:3px 0" type="button">
                                                <i class="fa fa-share-alt" aria-hidden="true"></i> <br> PAYLAŞ
                                            </button>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach





                </div>
            </div>
        </div>
    </div>
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
