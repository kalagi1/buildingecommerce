@extends('client.layouts.master')

@section('content')
    
<div class="container">
    <div class="form pt-4">
        <div class="row">
            <div class="col-md-12 mt-3 mb-3">
                <h3 style="font-size: 22px;">Formu Doldur</h3>
                
                <div class="mt-3 mb-3">
                    <p>Gayrimenkulunüzün detaylarını girin. Onay durumunda size dönüş sağlayacağz.</p>
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
                            <input type="text" value="{{old('name')}}" name="name" class="form-control inputForm">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Telefon Numarası</label>
                            <input type="text" value="{{old('phone')}}" name="phone" id="phone" class="form-control inputForm">
                            <span id="error_message" class="error-message"></span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">E-Posta Adresi</label>
                            <input type="email" value="{{old('email')}}" name="email" class="form-control inputForm">
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
                        <div class="container mt-3 mb-3">
                            <div style="display: flex; flex-wrap: wrap;">
                                <div style="flex: 1; margin-right: 10px;">
                                    <label for="city">İl:</label>
                                    <select class="form-control" id="city">
                                        <option value="">İl Seçiniz</option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}">{{ $city->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div style="flex: 1; margin-right: 10px;">
                                    <label for="district">İlçe:</label>
                                    <select class="form-control" id="district" disabled>
                                        <option value="">İlçe Seçiniz</option>
                                    </select>
                                </div>
                            
                                <div style="flex: 1;">
                                    <label for="neighborhood">Mahalle:</label>
                                    <select class="form-control" id="neighborhood" disabled>
                                        <option value="">Mahalle Seçiniz</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 mt-3 mb-3">
                            <label for="">Adres Açıklaması</label>
                            <input type="text" value="{{old('adres')}}" name="adres" class="form-control">
                        </div>

                        <div class="form-group col-md-12">
                            <label for="">Gayrimenkulünüz için belirlediğiniz fiyat</label>
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
                                <select class="form-select form-control" aria-label="Default select example" name="yapi_tipi">
                                    <option selected>Seçiniz</option>
                                    <option value="Yok">Yok</option>
                                    <option value="Ahşap">Ahşap</option>
                                    <option value="Kütük">Kütük</option>
                                    <option value="Betonarme">Betonarme</option>
                                    <option value="Çelik">Çelik</option>
                                    <option value="Prefabrik">Prefabrik</option>
                                    <option value="Yarı Kagir">Yarı Kagir</option>
                                    <option value="Tam Kagi">Tam Kagir</option>             
                                </select>
                            </div>

                                <div class="form-group col-md-4">
                                    <label for="">Bina Kat</label>
                                    <input type="number"  value="{{old('bina_kat')}}" name="bina_kat" class="form-control price-only">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bulunduğu Kat</label>
                                    <input type="number"  value="{{old('bulundugu_kat')}}" name="bulundugu_kat" class="form-control price-only">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="m2Net">M2 Net</label>
                                    <input type="number"  value="{{old('m2_net')}}" class="form-control price-only" name="m2_net">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="m2Brut">M2 Brüt</label>
                                    <input type="number"  value="{{old('m2_brut')}}" class="form-control price-only" name="m2_brut">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="binaYasi">Bina Yaşı</label>
                                    <input type="number"  value="{{old('bina_yasi')}}" class="form-control price-only" name="bina_yasi">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="cephe">Cephe</label>
                                    <select class="form-select form-control" aria-label="Default select example" name="cephe">
                                        <option selected>Seçiniz</option>
                                        <option value="Kuzey">Kuzey</option>
                                        <option value="Güney">Güney</option>
                                        <option value="Doğu">Doğu</option>
                                        <option value="Batı">Batı</option>
                                      </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="manzara">Manzara</label>
                                    <select class="form-select form-control" aria-label="Default select example" name="manzara">
                                        <option selected>Seçiniz</option>
                                        <option value="Doğa">Doğa</option>
                                        <option value="Deniz">Deniz</option>
                                        <option value="Orman">Orman</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="banyoTuvalet">Banyo/Tuvalet</label>
                                    <select class="form-select form-control" aria-label="Default select example" name="banyo_tuvalet">
                                        <option selected>Seçiniz</option>
                                        <option value="Yok">Yok</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10 ve üzeri">10 ve üzeri</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="isinma">Isınma</label>
                                    <select class="form-select form-control" aria-label="Default select example" name="isinma">
                                        <option selected>Seçiniz</option>
                                        <option value="Yok">Yok</option>
                                        <option value="Kombi (Doğalgaz)">Kombi (Doğalgaz)</option>
                                        <option value="Yerden Isıtma">Yerden Isıtma</option>
                                        <option value="Merkezi">Merkezi</option>
                                        <option value="Merkezi (Pay Ölçer)">Merkezi (Pay Ölçer)</option>
                                        <option value="Klima">Klima</option>
                                        <option value="Doğalgaz Sobası">Doğalgaz Sobası</option>
                                        <option value="Kat Kaloriferi">Kat Kaloriferi</option>
                                        <option value="Kombi (Elektrik)">Kombi (Elektrik)</option>
                                        <option value="Fancoil Ünitesi">Fancoil Ünitesi</option>
                                        <option value="Güneş Enerjisi">Güneş Enerjisi</option>
                                        <option value="Elektrikli Radyatör">Elektrikli Radyatör</option>
                                        <option value="Jeotermal">Jeotermal</option>
                                        <option value="Şömine">Şömine</option>
                                        <option value="VRV">VRV</option>
                                        <option value="Isı Pompası">Isı Pompası</option>
                                        <option value="Soba">Soba</option>
                                        <option value="Kalerifor">Kalerifor</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="odaSalon">Oda ve Salon</label>
                                    <select class="form-select form-control" aria-label="Default select example" name="oda_salon">
                                        <option selected>Seçiniz</option>
                                        <option value="1+0">1+0</option>
                                        <option value="1.5+1">1.5+1</option>
                                        <option value="2+0">2+0</option>
                                        <option value="2+1">2+1</option>
                                        <option value="2.5+1">2.5+1</option>
                                        <option value="3+0">3+0</option>
                                        <option value="3+1">3+1</option>
                                        <option value="3.5+1">3.5+1</option>
                                        <option value="3+2">3+2</option>
                                        <option value="3+3">3+3</option>
                                        <option value="4+0">4+0</option>
                                        <option value="4+1">4+1</option>
                                        <option value="4.5+1">4.5+1</option>
                                        <option value="4+2">4+2</option>
                                        <option value="4+3">4+3</option>
                                        <option value="4+4">4+4</option>
                                        <option value="5+1">5+1</option>
                                        <option value="5.5+1">5.5+1</option>
                                        <option value="5+2">5+2</option>
                                        <option value="5+3">5+3</option>
                                        <option value="5+4">5+4</option>
                                        <option value="6+1">6+1</option>
                                        <option value="6+2">6+2</option>
                                        <option value="6.5+1">6.5+1</option>
                                        <option value="6+3">6+3</option>
                                        <option value="6+4">6+4</option>
                                        <option value="7+1">7+1</option>
                                        <option value="7+2">7+2</option>
                                        <option value="7+3">7+3</option>
                                        <option value="8+1">8+1</option>
                                        <option value="8+2">8+2</option>
                                        <option value="8+3">8+3</option>
                                        <option value="8+4">8+4</option>
                                        <option value="9+1">9+1</option>
                                        <option value="9+2">9+2</option>
                                        <option value="9+3">9+3</option>
                                        <option value="9+4">9+4</option>
                                        <option value="9+5">9+5</option>
                                        <option value="9+6">9+6</option>
                                        <option value="10+1">10+1</option>
                                        <option value="10+2">10+2</option>
                                        <option value="11+1">11+1</option>
                                        <option value="12 ve üzeri">12 ve üzeri</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tapu">Tapu</label>
                                    <select class="form-select form-control" aria-label="Default select example" name="tapu">
                                        <option selected>Seçiniz</option>
                                        <option value="Hisseli Tapu">Hisseli Tapu</option>
                                        <option value="Müstakil Tapulu">Müstakil Tapulu</option>
                                        <option value="Kat Mülkiyetli">Kat Mülkiyetli</option>
                                        <option value="Kat İrtifaklı">Kat İrtifaklı</option>
                                        <option value="Arsa Tapulu">Arsa Tapulu</option>
                                        <option value="Bilinmiyor">Bilinmiyor</option>
                                    </select>
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

                    <div class="col-md-12 fl-wrap filter-tags clearfix mt-3 mb-3">
                        <fieldset>
                            <div class="checkboxes float-right">                        
                                <div class="filter-tags-wrap ">
                                    <input id="check-b" type="checkbox" name="check-b">
                                    <label for="check-b" style="font-size: 11px;">
                                        <a href="https://emlaksepette.com/sayfa/gayrimenkul-kayit-bilgilendirme-politikasi" target="_blank">
                                            Sat Kirala Formu sözleşmesini
                                        </a>
                                        okudum onaylıyorum.
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary mr-5"
                        style="width: 200px; float:right">Başvuruyu Tamamla</button>
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
        $(document).ready(function(){
          $("#phone").blur(function(){
            var phoneNumber = $(this).val();
            var pattern = /^5[1-9]\d{8}$/;
        
            if (!pattern.test(phoneNumber)) {
              $("#error_message").text("Lütfen telefon numarasını belirtilen formatta girin. Örneğin: (555) 111 22 33");
            } else {
              $("#error_message").text("");
            }
          });
        });
        </script>
    <script>

$(document).ready(function() {
        $('#check-b').change(function() {
            if ($(this).is(':checked')) {
                $('#applicationForm').submit();
            }
        });
    });
    
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
    <script>
$(document).ready(function() {

    // İl seçildiğinde ilçelerin yüklenmesi
    $('#city').change(function() {
        var cityId = $(this).val();
        if(cityId) {
            $.ajax({
                type: "GET",
                url: "{{ route('get-districts', ['city_id' => '__cityId__']) }}".replace('__cityId__', cityId), // cityId parametresini rotaya ekliyoruz
                success: function(data) {
                    console.log(data);
                    if(data) {
                        $('#district').html('<option value="">İlçe Seçiniz</option>');
                        $.each(data, function(index, district) {
                            $('#district').append('<option value="'+ district.ilce_key +'">'+ district.ilce_title +'</option>');
                        });
                        $('#district').prop('disabled', false);
                    } else {
                        $('#district').html('<option value="">İlçe bulunamadı</option>');
                        $('#district').prop('disabled', true);
                    }
                }
            });
        } else {
            $('#district').html('<option value="">İlçe Seçiniz</option>');
            $('#district').prop('disabled', true);
        }
    });

    // İlçe seçildiğinde mahallelerin yüklenmesi
    $('#district').change(function() {
        var districtId = $(this).val();
        console.log(districtId)
        if(districtId) {
            $.ajax({
                type: "GET",
                url: "{{ route('get-neighborhoods', ['districtId' => '__districtId__']) }}".replace('__districtId__', districtId), 
                success: function(data) {
                    console.log(data)
                    if(data) {
                        $('#neighborhood').html('<option value="">Mahalle Seçiniz</option>');
                        $.each(data, function(index, neighborhoods) {
                            $('#neighborhood').append('<option value="'+ neighborhoods.mahalle_id +'">'+ neighborhoods.mahalle_title +'</option>');
                        });
                        $('#neighborhood').prop('disabled', false);
                    } else {
                        $('#neighborhood').html('<option value="">Mahalle bulunamadı</option>');
                        $('#neighborhood').prop('disabled', true);
                    }
                }
            });
        } else {
            $('#neighborhood').html('<option value="">Mahalle Seçiniz</option>');
            $('#neighborhood').prop('disabled', true);
        }
    });

    
    // İlçe veya mahalle seçildiğinde adres açıklaması inputunu güncelle
    $('#district, #neighborhood').change(function() {
        
        var city = $('#city option:selected').text();
        var district = $('#district option:selected').text();
        var neighborhood = $('#neighborhood option:selected').text();
        var address = city + ' ili, ' + district + ' ilçesi, ' + neighborhood + ' mahallesi';
        $('input[name="adres"]').val(address);
    });





});





        </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
                .error-message {
            color: red;
            font-size: 11px;
        }
        .inputForm{
            width: 331px;
            height: 26px;
            border-radius: 5px !important;  
            color: #FFFFFF;
            border: 1px solid #CCCCCCCC !important;
        }

        .inputForm:hover{
            width: 331px;
            height: 26px;
            border-radius: 5px !important;

            border: 1px solid #5ea3fc !important;
        }
    </style>
@endsection