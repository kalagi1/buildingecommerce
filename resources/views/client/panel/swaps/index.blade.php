@extends('client.layouts.master')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

@section('content')
    <div class="content">
        <h3 class=" mt-2 mb-4">Gelen Takas Başvuruları</h3>
        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-white">
            <div class="table-responsive mx-n1 px-1 scrollbar">
                <table class="table table-sm  border-200 fs--1 mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>İsim</th>
                            <th>Soyad</th>
                            <th>Telefon</th>
                            <th>E-mail</th>
                            <th>Detaylar</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apps as $index => $app)
                            <tr>
                                <td>
                                    {{ $index + 1 }}
                                </td>
                                <td>{{ $app->ad }}</td>
                                <td>{{ $app->soyad }}</td>
                                <td>{{ $app->telefon }}</td>
                                <td>{{ $app->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $app->id }}">
                                        Detaylar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($apps as $key => $app)
        <div class="modal fade" id="detailModal{{ $app->id }}" tabindex="-1" role="dialog"
            aria-labelledby="detailModalLabel{{ $app->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $app->id }}"> {{ $key + 1 }}. Başvuru
                            Detayları</h5>

                    </div>
                    <div class="modal-body">
                        @foreach ($app->toArray() as $key => $value)
                            @if (!is_null($value) && $key !== 'id' && $key !== 'store_id' && $key !== 'created_at' && $key !== 'updated_at')
                                @php
                                    $label = '';
                                    $link = null;
                                    switch ($key) {
                                        case 'ad':
                                            $label = 'Adı';
                                            break;
                                        case 'soyad':
                                            $label = 'Soyadı';
                                            break;
                                        case 'telefon':
                                            $label = 'Telefon Numarası';
                                            break;
                                        case 'email':
                                            $label = 'E-posta';
                                            break;
                                        case 'sehir':
                                            $city = \App\Models\City::find($value);
                                            $value = $city ? $city->title : '';
                                            $label = 'Şehir';
                                            break;
                                        case 'ilce':
                                            $district = \App\Models\District::where('ilce_key', $value)->first();
                                            $value = $district ? $district->ilce_title : '';
                                            $label = 'İlçe';
                                            break;
                                        case 'takas_tercihi':
                                            $label = 'Takas Tercihi';
                                            break;
                                        case 'diger_detay':
                                            $label = 'Diğer Detay';
                                            break;
                                        case 'barter_detay':
                                            $label = 'Barter Detay';
                                            break;
                                        case 'emlak_tipi':
                                            $label = 'Emlak Tipi';
                                            break;
                                        case 'konut_tipi':
                                            $label = 'Konut Tipi';
                                            break;
                                        case 'oda_sayisi':
                                            $label = 'Oda Sayısı';
                                            break;
                                        case 'konut_yasi':
                                            $label = 'Konut Yaşı';
                                            break;
                                        case 'kullanim_durumu':
                                            $label = 'Kullanım Durumu';
                                            break;
                                        case 'satis_rakami':
                                            $label = 'Satış Rakamı';
                                            break;
                                        case 'konut_satis_rakami':
                                            $label = 'Satış Rakamı';
                                            break;
                                        case 'arsa_il':
                                            $label = 'Arsa İli';
                                            break;
                                        case 'arsa_ilce':
                                            $label = 'Arsa İlçe';
                                            break;
                                        case 'arsa_mahalle':
                                            $label = 'Arsa Mahallesi';
                                            break;
                                        case 'ada_parsel':
                                            $label = 'Ada Parsel Bilgisi';
                                            break;
                                        case 'imar_durumu':
                                            $label = 'İmar Durumu';
                                            break;
                                        case 'arac_model_yili':
                                            $label = 'Araç Model Yılı';
                                            break;
                                        case 'arac_markasi':
                                            $label = 'Araç Markası';
                                            break;
                                        case 'yakit_tipi':
                                            $label = 'Yakıt Tipi';
                                            break;
                                        case 'vites_tipi':
                                            $label = 'Vites Tipi';
                                            break;
                                        case 'arac_satis_rakami':
                                            $label = 'Araç Satış Rakamı';
                                            break;
                                        case 'ticari_bilgiler':
                                            $label = 'Ticari Bilgiler';
                                            break;
                                        case 'isyeri_satis_rakami':
                                            $label = 'İşyeri Satış Rakamı';
                                            break;
                                        case 'tapu_belgesi':
                                            $label = 'Tapu Belgesi';
                                            $link = asset('storage/tapuFiles/' . $value);
                                            break;
                                        case 'ruhsat_belgesi':
                                            $label = 'Ruhsat Belgesi';
                                            $link = asset('storage/ruhsatFiles/' . $value);
                                            break;
                                        default:
                                            $label = ucwords(str_replace('_', ' ', $key));
                                    }
                                @endphp
                                @if (isset($link) && !empty($link))
                                    <p><strong>{{ $label }}:</strong> <a href="{{ $link }}"
                                            download>İndir</a></p>
                                @else
                                    <p><strong>{{ $label }}:</strong> {{ $value }}</p>
                                @endif
                            @endif
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endforeach
@endsection

@section('scripts')
    <script src="//cdn.ckeditor.com/4.21.0/full/ckeditor.js"></script>
    <script>
        $(document).ready(function() {
            function createEditor(itemId) {
                var editorId = 'content_' + itemId; // CKEDITOR'ün benzersiz ID'si
                CKEDITOR.replace(editorId, {
                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                    filebrowserUploadMethod: 'form'
                });
            }

            // CKEDITOR içeriğini almak için bir fonksiyon
            function getContent(itemId) {
                return CKEDITOR.instances['content_' + itemId].getData();
            }
        });
    </script>

    <script>
        function updateResponseText(itemId) {
            var toggle = document.getElementById('response_toggle' + itemId);
            var label = document.querySelector('label[for=response_toggle' + itemId + ']');
            if (toggle.checked) {
                label.textContent = 'Olumlu Değerlendirildi';
            } else {
                label.textContent = 'Olumsuz Değerlendirildi';
            }
        }
    </script>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
@endsection

@section('css')
    <style>
        .custom-control-input:checked+.custom-control-label::before {
            background-color: green !important;
        }

        .custom-control-input:not(:checked)+.custom-control-label::before {
            background-color: red !important;
        }

        .profile-initial {
            font-size: 20px;
            color: #e54242;
            background: white;
            padding: 5px;
            border: 1px solid #e6e6e6;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
        }
    </style>
@endsection
