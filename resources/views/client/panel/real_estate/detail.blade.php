@extends('institutional.layouts.master')

@section('content')
    <div class="content">
        <div class="mt-4">
            <div class="card p-3">
                <ul style="list-style: none;padding: 0;">
                    <li>İsim Soyisim : {{$realEstate->name}}</li>
                    <li>Telefon Numarası : {{$realEstate->phone}}</li>
                    <li>E-Posta : {{$realEstate->email}}</li>
                    <li>Konut : @if($realEstate->konut == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Ticari : @if($realEstate->ticari == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Kiralık : @if($realEstate->kiralik == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Satılık : @if($realEstate->satilik == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Devren : @if($realEstate->devren == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Adres : {{$realEstate->adres}}</li>
                    <li>İstenilen Fiyat : {{$realEstate->istenilen_fiyat}}</li>
                    <li>İlan Açıklaması : {{$realEstate->ilan_aciklamasi}}</li>
                    <li>Sözleşme : @if($realEstate->sozlesme == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Afiş : @if($realEstate->afis == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Anahtar Yetkili : @if($realEstate->anahtar_yetkili == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif</li>
                    <li>Yapı Tipi : {{$realEstate->yapi_tipi}}</li>
                    <li>Bina Kat : {{$realEstate->bina_kat}}</li>
                    <li>Bulunduğu Kat : {{$realEstate->bulundugu_kat}}</li>
                    <li>Metrekare Net : {{$realEstate->m2_net}}</li>
                    <li>Metrekare Brüt : {{$realEstate->m2_brut}}</li>
                    <li>Bina Yaşı : {{$realEstate->bina_yasi}}</li>
                    <li>Cephe : {{$realEstate->cephe}}</li>
                    <li>Manzara : {{$realEstate->manzara}}</li>
                    <li>Banyo Tuvalet : {{$realEstate->banyo_tuvalet}}</li>
                    <li>Isınma : {{$realEstate->isinma}}</li>
                    <li>Oda Salon : {{$realEstate->oda_salon}}</li>
                    <li>Tapu : {{$realEstate->tapu}}</li>
                </ul>
                <div class="row">
                    <div class="col-md-4 mt-3">
                        DSL : @if($realEstate->dsl == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif
                    </div>
                    <div class="col-md-4 mt-3">
                       ASANSÖR : @if($realEstate->asansor == 1) <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span> @else <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span> @endif
                    </div>
                    <!-- 1. Div -->
                    <div class="col-md-4 mt-3">
                        ESYALI :
                        @if($realEstate->esyali == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 2. Div -->
                    <div class="col-md-4 mt-3">
                        GARAJ :
                        @if($realEstate->garaj == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 3. Div -->
                    <div class="col-md-4 mt-3">
                        BARBEKU :
                        @if($realEstate->barbeku == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 4. Div -->
                    <div class="col-md-4 mt-3">
                        BOYALI :
                        @if($realEstate->boyali == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 5. Div -->
                    <div class="col-md-4 mt-3">
                        ÇAM ODASI :
                        @if($realEstate->cam_odasi == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 6. Div -->
                    <div class="col-md-4 mt-3">
                        ÇELIK KAPI :
                        @if($realEstate->celik_kapi == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 7. Div -->
                    <div class="col-md-4 mt-3">
                        DUSAKABIN :
                        @if($realEstate->dusakabin == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 8. Div -->
                    <div class="col-md-4 mt-3">
                        INTERCOM :
                        @if($realEstate->intercom == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 9. Div -->
                    <div class="col-md-4 mt-3">
                        JAKUZI :
                        @if($realEstate->jakuzi == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 10. Div -->
                    <div class="col-md-4 mt-3">
                        MSD :
                        @if($realEstate->msd == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 11. Div -->
                    <div class="col-md-4 mt-3">
                        JENERATOR :
                        @if($realEstate->jenerator == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 12. Div -->
                    <div class="col-md-4 mt-3">
                        MUTFAK D :
                        @if($realEstate->mutfak_d == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 13. Div -->
                    <div class="col-md-4 mt-3">
                        SAUNA :
                        @if($realEstate->sauna == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 14. Div -->
                    <div class="col-md-4 mt-3">
                        SERAMIK Z :
                        @if($realEstate->seramik_z == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 15. Div -->
                    <div class="col-md-4 mt-3">
                        SU DEPOSU :
                        @if($realEstate->su_deposu == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 16. Div -->
                    <div class="col-md-4 mt-3">
                        SOMINE :
                        @if($realEstate->somine == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 17. Div -->
                    <div class="col-md-4 mt-3">
                        TERAS :
                        @if($realEstate->teras == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 18. Div -->
                    <div class="col-md-4 mt-3">
                        GUVENLIK :
                        @if($realEstate->guvenlik == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 19. Div -->
                    <div class="col-md-4 mt-3">
                        GONME DOLAP :
                        @if($realEstate->gonme_dolap == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 20. Div -->
                    <div class="col-md-4 mt-3">
                        KABLO TV :
                        @if($realEstate->kablo_tv == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 21. Div -->
                    <div class="col-md-4 mt-3">
                        MUTFAK L :
                        @if($realEstate->mutfak_l == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 22. Div -->
                    <div class="col-md-4 mt-3">
                        OTOPARK :
                        @if($realEstate->otopark == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 23. Div -->
                    <div class="col-md-4 mt-3">
                        GÖR DIAFON :
                        @if($realEstate->gor_diafon == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 24. Div -->
                    <div class="col-md-4 mt-3">
                        KILER :
                        @if($realEstate->kiler == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>

                    <!-- 25. Div -->
                    <div class="col-md-4 mt-3">
                        OYUN PARKI :
                        @if($realEstate->oyun_parki == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    <div class="col-md-4 mt-3">
                        HIDROFOR :
                        @if($realEstate->hidrofor == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 33. Div -->
                    <div class="col-md-4 mt-3">
                        KLIMA :
                        @if($realEstate->klima == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 34. Div -->
                    <div class="col-md-4 mt-3">
                        PVC :
                        @if($realEstate->pvc == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 35. Div -->
                    <div class="col-md-4 mt-3">
                        HILTON BANYON :
                        @if($realEstate->hilton_banyo == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 36. Div -->
                    <div class="col-md-4 mt-3">
                        KOMBI :
                        @if($realEstate->kombi == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    <div class="col-md-4 mt-3">
                        PANJUR :
                        @if($realEstate->panjur == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 38. Div -->
                    <div class="col-md-4 mt-3">
                        ISICAM :
                        @if($realEstate->isicam == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 39. Div -->
                    <div class="col-md-4 mt-3">
                        LAMINANT Z. :
                        @if($realEstate->laminant_z == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 40. Div -->
                    <div class="col-md-4 mt-3">
                        PARKE :
                        @if($realEstate->parke == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 41. Div -->
                    <div class="col-md-4 mt-3">
                        YANGIN M. :
                        @if($realEstate->yangin_m == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 42. Div -->
                    <div class="col-md-4 mt-3">
                        YUZME H. :
                        @if($realEstate->yuzme_havuzu == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                    
                    <!-- 43. Div -->
                    <div class="col-md-4 mt-3">
                        Wi-Fi :
                        @if($realEstate->wifi == 1)
                            <span class="badge badge-phoenix badge-phoenix-success"><i class="fa fa-check"></i></span>
                        @else
                            <span class="badge badge-phoenix badge-phoenix-danger"><i class="fa fa-times"></i></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 5">
            <div class="toast align-items-center text-white bg-dark border-0 light" id="icon-copied-toast" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body p-3"></div><button class="btn-close btn-close-white me-2 m-auto" type="button"
                        data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
@endsection
