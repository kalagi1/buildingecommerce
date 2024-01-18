@extends('client.layouts.master')

@section('content')
    
<div class="container">
    <div class="form pt-4">
        <div class="row">
            <div class="col-md-12 mt-3 mb-3">
                <h3 style="font-size: 22px;">Emlak Sepette Aracılığıyla Mülkünü Sat/Kirala</h3>
                
                <div class="mt-3 mb-3">
                    <p>Türkiye'de İlk Emlak Sepette Hoşgeldiniz
                        Emlak Sepette aracılığıyla mülkünü sat kirala. Mülkünüzü Türkiye geneli emlak danışmanlarıyla %100 güvenli ve garantili satmak ve hızlı satılması için hemen formu doldur. Biz senin için en uygun emlak firmasını / emlak danışmanını bulalım</p>
                </div>

                <form action="{{route('real.estate.post')}}" method="post">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color:#fff;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="">İsim Soyisim</label>
                            <input type="text" value="{{old('name')}}" name="name" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Telefon Numarası</label>
                            <input type="text" value="{{old('phone')}}" name="phone" class="form-control">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">E-Posta Adresi</label>
                            <input type="email" value="{{old('email')}}" name="email" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h3 style="font-size: 16px;font-weight: 600;">İlan Bilgileri</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-6 mt-2 mb-2" style="align-items: center;">
                                    <input type="radio" @if(old('type_1') == "konut") checked @endif name="type_1" value="konut" id="konut">
                                    <label for="konut" class="ml-2 mb-0">Konut</label>
                                </div>
                                <div class="form-group d-flex col-md-6  mt-2 mb-2" style="align-items: center;">
                                    <input type="radio" @if(old('type_1') == "ticari") checked @endif name="type_1" value="ticari" id="ticari">
                                    <label for="ticari" class="ml-2 mb-0">Ticari</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input type="radio" @if(old('type_2') == "kiralik") checked @endif name="type_2" value="kiralik" id="kiralik">
                                    <label for="kiralik" class="ml-2 mb-0">Kiralık</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input type="radio" @if(old('type_2') == "satilik") checked @endif name="type_2" value="satilik" id="satilik">
                                    <label for="satilik" class="ml-2 mb-0">Satılık</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input type="radio" @if(old('type_2') == "devren") checked @endif name="type_2" value="devren" id="devren">
                                    <label for="devren" class="ml-2 mb-0">Devren</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Adres</label>
                            <input type="text" value="{{old('adres')}}" name="adres" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">İstenen Fiyat</label>
                            <input type="text" value="{{old('istenilen_fiyat')}}" name="istenilen_fiyat" class="form-control price-only">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">İlan Açıklaması</label>
                            <textarea name="ilan_aciklamasi" class="form-control" id="" cols="30" rows="10" style="height: 80px !important;" >{{old('ilan_aciklamasi')}}</textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" @if(old('sozlesme') == 1) checked @endif name="sozlesme" value="1" id="sozlesme">
                                    <label for="sozlesme" class="ml-2 mb-0">Sözleşme</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" @if(old('afis') == 1) checked @endif name="afis" value="1" id="afis">
                                    <label for="afis" class="ml-2 mb-0">Afiş</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" @if(old('anahtar_yetkili') == 1) checked @endif name="anahtar_yetkili" value="1" id="anahtar-yetkili">
                                    <label for="anahtar-yetkili" class="ml-2 mb-0">Anahtar Yetkili</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Yapı Tipi</label>
                                    <input type="text"  value="{{old('yapi_tipi')}}" name="yapi_tipi" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bina Kat</label>
                                    <input type="text"  value="{{old('bina_kat')}}" name="bina_kat" class="form-control price-only">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bulunduğu Kat</label>
                                    <input type="text"  value="{{old('bulundugu_kat')}}" name="bulundugu_kat" class="form-control price-only">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="m2Net">M2 Net</label>
                                    <input type="text"  value="{{old('m2_net')}}" class="form-control price-only" name="m2_net">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="m2Brut">M2 Brüt</label>
                                    <input type="text"  value="{{old('m2_brut')}}" class="form-control price-only" name="m2_brut">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="binaYasi">Bina Yaşı</label>
                                    <input type="text"  value="{{old('bina_yasi')}}" class="form-control price-only" name="bina_yasi">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cephe">Cephe</label>
                                    <input type="text"  value="{{old('cephe')}}" class="form-control" name="cephe">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="manzara">Manzara</label>
                                    <input type="text"  value="{{old('manzara')}}" class="form-control" name="manzara">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="banyoTuvalet">Banyo/Tuvalet</label>
                                    <input type="text"  value="{{old('banyo_tuvalet')}}" class="form-control price-only" name="banyo_tuvalet">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="isinma">Isınma</label>
                                    <input type="text"  value="{{old('isinma')}}" class="form-control" name="isinma">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="odaSalon">Oda ve Salon</label>
                                    <input type="text"  value="{{old('oda_salon')}}" class="form-control" name="oda_salon">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tapu">Tapu</label>
                                    <input type="text"  value="{{old('tapu')}}" class="form-control" name="tapu">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('DSL',old('features',[]))) checked @endif type="checkbox" name="features[]" id="dsl" value="DSL">
                                    <label for="dsl" class="ml-2 mb-0">DSL</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('ASANSÖR',old('features',[]))) checked @endif type="checkbox" name="features[]" id="asansor" value="ASANSÖR">
                                    <label for="asansor" class="ml-2 mb-0">ASANSÖR</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('EŞYALI',old('features',[]))) checked @endif type="checkbox" name="features[]" id="esyali" value="EŞYALI">
                                    <label for="esyali" class="ml-2 mb-0">EŞYALI</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('GARAJ',old('features',[]))) checked @endif type="checkbox" name="features[]" id="garaj" value="GARAJ">
                                    <label for="garaj" class="ml-2 mb-0">GARAJ</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('BARBEKÜ',old('features',[]))) checked @endif type="checkbox" name="features[]" id="barbeku" value="BARBEKÜ">
                                    <label for="barbeku" class="ml-2 mb-0">BARBEKÜ</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('BOYALI',old('features',[]))) checked @endif type="checkbox" name="features[]" id="boyali" value="BOYALI">
                                    <label for="boyali" class="ml-2 mb-0">BOYALI</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('ÇAM. ODASI',old('features',[]))) checked @endif type="checkbox" name="features[]" id="cam-odasi" value="ÇAM. ODASI">
                                    <label for="cam-odasi" class="ml-2 mb-0">ÇAM. ODASI</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('ÇELİK KAPI',old('features',[]))) checked @endif type="checkbox" name="features[]" id="celik-kapi" value="ÇELİK KAPI">
                                    <label for="celik-kapi" class="ml-2 mb-0">ÇELİK KAPI</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('DUŞAKABİN',old('features',[]))) checked @endif type="checkbox" name="features[]" id="dusakabin" value="DUŞAKABİN">
                                    <label for="dusakabin" class="ml-2 mb-0">DUŞAKABİN</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('İNTERCOM', old('features', []))) checked @endif type="checkbox" name="features[]" id="intercom" value="İNTERCOM">
                                    <label for="intercom" class="ml-2 mb-0">İNTERCOM</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('JAKUZİ', old('features', []))) checked @endif type="checkbox" name="features[]" id="jakuzi" value="JAKUZİ">
                                    <label for="jakuzi" class="ml-2 mb-0">JAKUZİ</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('M.S.D.', old('features', []))) checked @endif type="checkbox" name="features[]" id="msd" value="M.S.D.">
                                    <label for="msd" class="ml-2 mb-0">M.S.D.</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('JENERATÖR', old('features', []))) checked @endif type="checkbox" name="features[]" id="jenerator" value="JENERATÖR">
                                    <label for="jenerator" class="ml-2 mb-0">JENERATÖR</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('MUTFAK D.', old('features', []))) checked @endif type="checkbox" name="features[]" id="mutfak-d" value="MUTFAK D.">
                                    <label for="mutfak-d" class="ml-2 mb-0">MUTFAK D.</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('SAUNA', old('features', []))) checked @endif type="checkbox" name="features[]" id="sauna" value="SAUNA">
                                    <label for="sauna" class="ml-2 mb-0">SAUNA</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('SERAMİK Z.', old('features', []))) checked @endif type="checkbox" name="features[]" id="seramik-z" value="SERAMİK Z.">
                                    <label for="seramik-z" class="ml-2 mb-0">SERAMİK Z.</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('SU DEPOSU', old('features', []))) checked @endif type="checkbox" name="features[]" id="su-deposu" value="SU DEPOSU">
                                    <label for="su-deposu" class="ml-2 mb-0">SU DEPOSU</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('ŞÖMİNE', old('features', []))) checked @endif type="checkbox" name="features[]" id="somine" value="ŞÖMİNE">
                                    <label for="somine" class="ml-2 mb-0">ŞÖMİNE</label>
                                </div>
                            </div>
                            
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('TERAS', old('features', []))) checked @endif type="checkbox" name="features[]" id="teras" value="TERAS">
                                    <label for="teras" class="ml-2 mb-0">TERAS</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('GÜVENLİK', old('features', []))) checked @endif type="checkbox" name="features[]" id="guvenlik" value="GÜVENLİK">
                                    <label for="guvenlik" class="ml-2 mb-0">GÜVENLİK</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('GÖNME DOLAP', old('features', []))) checked @endif type="checkbox" name="features[]" id="gonme-dolap" value="GÖNME DOLAP">
                                    <label for="gonme-dolap" class="ml-2 mb-0">GÖNME DOLAP</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('KABLO TV', old('features', []))) checked @endif type="checkbox" name="features[]" id="kablo-tv" value="KABLO TV">
                                    <label for="kablo-tv" class="ml-2 mb-0">KABLO TV</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('MUTFAK L.', old('features', []))) checked @endif type="checkbox" name="features[]" id="mutfak-l" value="MUTFAK L.">
                                    <label for="mutfak-l" class="ml-2 mb-0">MUTFAK L.</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('OTOPARK', old('features', []))) checked @endif type="checkbox" name="features[]" id="otopark" value="OTOPARK">
                                    <label for="otopark" class="ml-2 mb-0">OTOPARK</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('GÖR. DİAFON', old('features', []))) checked @endif type="checkbox" name="features[]" id="gor-diafon" value="GÖR. DİAFON">
                                    <label for="gor-diafon" class="ml-2 mb-0">GÖR. DİAFON</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('KİLER', old('features', []))) checked @endif type="checkbox" name="features[]" id="kiler" value="KİLER">
                                    <label for="kiler" class="ml-2 mb-0">KİLER</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('OYUN PARKI', old('features', []))) checked @endif type="checkbox" name="features[]" id="oyun-parki" value="OYUN PARKI">
                                    <label for="oyun-parki" class="ml-2 mb-0">OYUN PARKI</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('HİDROFOR', old('features', []))) checked @endif type="checkbox" name="features[]" id="hidrofor" value="HİDROFOR">
                                    <label for="hidrofor" class="ml-2 mb-0">HİDROFOR</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('KLİMA', old('features', []))) checked @endif type="checkbox" name="features[]" id="klima" value="KLİMA">
                                    <label for="klima" class="ml-2 mb-0">KLİMA</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('PVC', old('features', []))) checked @endif type="checkbox" name="features[]" id="pvc" value="PVC">
                                    <label for="pvc" class="ml-2 mb-0">PVC</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('HİLTON BANYON', old('features', []))) checked @endif type="checkbox" name="features[]" id="hilton-banyo" value="HİLTON BANYON">
                                    <label for="hilton-banyo" class="ml-2 mb-0">HİLTON BANYON</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('KOMBİ', old('features', []))) checked @endif type="checkbox" name="features[]" id="kombi" value="KOMBİ">
                                    <label for="kombi" class="ml-2 mb-0">KOMBİ</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('PANJUR', old('features', []))) checked @endif type="checkbox" name="features[]" id="panjur" value="PANJUR">
                                    <label for="panjur" class="ml-2 mb-0">PANJUR</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('ISICAM', old('features', []))) checked @endif type="checkbox" name="features[]" id="isicam" value="ISICAM">
                                    <label for="isicam" class="ml-2 mb-0">ISICAM</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('LAMİNANT Z.', old('features', []))) checked @endif type="checkbox" name="features[]" id="laminant-z" value="LAMİNANT Z.">
                                    <label for="laminant-z" class="ml-2 mb-0">LAMİNANT Z.</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('PARKE', old('features', []))) checked @endif type="checkbox" name="features[]" id="parke" value="PARKE">
                                    <label for="parke" class="ml-2 mb-0">PARKE</label>
                                </div>
                            </div>
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('YANGIN M.', old('features', []))) checked @endif type="checkbox" name="features[]" id="yangin-m" value="YANGIN M.">
                                    <label for="yangin-m" class="ml-2 mb-0">YANGIN M.</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('YÜZME H.', old('features', []))) checked @endif type="checkbox" name="features[]" id="yuzme-havuzu" value="YÜZME H.">
                                    <label for="yuzme-havuzu" class="ml-2 mb-0">YÜZME H.</label>
                                </div>
                            
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input @if(in_array('Wi-Fi', old('features', []))) checked @endif type="checkbox" name="features[]" id="wifi" value="Wi-Fi">
                                    <label for="wifi" class="ml-2 mb-0">Wi-Fi</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"
                        style="width: 200px; float:right">Sat/Kirala</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if(request('status') == "new_form_send")
            toastr.success("Başarıyla sat kirala formunuz iletildi. En kısa sürede sizinle iletişime geçilecektir.");
        @endif

        $('.price-only').keyup(function(){
            if($(this).val().replace('.','').replace('.','').replace('.','').replace('.','') != parseInt($(this).val().replace('.','').replace('.','').replace('.','').replace('.','').replace('.','') )){
                if($(this).closest('.form-group').find('.error-text').length > 0){
                    $(this).val("");
                }else{
                    $(this).closest('.form-group').append('<span class="error-text">Girilen değer sadece sayı olmalıdır</span>')
                    $(this).val("");
                }
                
            }else{
                let inputValue = $(this).val();

                // Sadece sayı karakterlerine izin ver
                inputValue = inputValue.replace(/\D/g, '');

                // Her üç basamakta bir nokta ekleyin
                inputValue = inputValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

                $(this).val(inputValue)
                $(this).closest('.form-group').find('.error-text').remove();
            }
        })
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection