@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Mağaza Takas Başvuruları</h4>
                    <table class="table mt-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ad</th>
                                <th>Soyad</th>
                                <th>Telefon</th>
                                <th>Email</th>
                                <th>Detaylar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apps as $app)
                                <tr>
                                    <td><span>{{ $loop->iteration }}</span></td>
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

        <!-- Modal -->
        @foreach ($apps as $app)
            <div class="modal fade" id="detailModal{{ $app->id }}" tabindex="-1" role="dialog"
                aria-labelledby="detailModalLabel{{ $app->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailModalLabel{{ $app->id }}">Başvuru Detayları</h5>

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
                                                $label = 'Şehir';
                                                break;
                                            case 'ilce':
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
    <!-- İhtiyacınıza göre scriptler ekleyebilirsiniz -->
@endsection

@section('css')
    <!-- İhtiyacınıza göre CSS ekleyebilirsiniz -->
@endsection
