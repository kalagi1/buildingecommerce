@extends('client.layouts.master')

@section('content')
    
<div class="container">
    <div class="form pt-4">
        <div class="row">
            <div class="col-md-9">
                <h3 style="font-size: 22px;">Emlak Sepette Aracılığıyla Mülkünü Sat/Kirala</h3>
                
                <div class="mt-3 mb-3">
                    <p>Türkiye'de İlk Emlak Sepette Hoşgeldiniz
                        Emlak Sepette aracılığıyla mülkünü sat kirala. Mülkünüzü Türkiye geneli emlak danışmanlarıyla %100 güvenli ve garantili satmak ve hızlı satılması için hemen formu doldur. Biz senin için en uygun emlak firmasını / emlak danışmanını bulalım</p>
                </div>

                <form action="">
                    @csrf
        
                    <div class="row">
                        <div class="col-md-6">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-6 mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="konut">
                                    <label for="konut" class="ml-2 mb-0">Konut</label>
                                </div>
                                <div class="form-group d-flex col-md-6  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="ticari">
                                    <label for="ticari" class="ml-2 mb-0">Ticari</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="kiralik">
                                    <label for="kiralik" class="ml-2 mb-0">Kiralık</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="satilik">
                                    <label for="satilik" class="ml-2 mb-0">Satılık</label>
                                </div>
                                <div class="form-group d-flex col-md-4 mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="devren">
                                    <label for="devren" class="ml-2 mb-0">Devren</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="">Adres</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">İstenen Fiyat</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="">İlan Açıklaması</label>
                            <textarea name="" class="form-control" id="" cols="30" rows="10" style="height: 100px !important;" ></textarea>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="sozlesme">
                                    <label for="sozlesme" class="ml-2 mb-0">Sözleşme</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="afis">
                                    <label for="afis" class="ml-2 mb-0">Afiş</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="anahtar-yetkili">
                                    <label for="anahtar-yetkili" class="ml-2 mb-0">Anahtar Yetkili</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="">Yapı Tipi</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bina Kat</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bulunduğu Kat</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">M2 Net</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">M2 Brüt</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Bina Yaşı</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Cephe</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Manzara</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Banyo/Tuvalet</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Isınma</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Oda ve Salon</label>
                                    <input type="text" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Tapu</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="dsl">
                                    <label for="dsl" class="ml-2 mb-0">DSL</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="asansor">
                                    <label for="asansor" class="ml-2 mb-0">ASANSÖR</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="esyali">
                                    <label for="esyali" class="ml-2 mb-0">EŞYALI</label>
                                </div>
                            </div>
                        
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="garaj">
                                    <label for="garaj" class="ml-2 mb-0">GARAJ</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="barbeku">
                                    <label for="barbeku" class="ml-2 mb-0">BARBEKÜ</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="boyali">
                                    <label for="boyali" class="ml-2 mb-0">BOYALI</label>
                                </div>
                            </div>
                        
                            <div class="d-flex b-estate-form mb-2">
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="cam-odasi">
                                    <label for="cam-odasi" class="ml-2 mb-0">ÇAM. ODASI</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="celik-kapi">
                                    <label for="celik-kapi" class="ml-2 mb-0">ÇELİK KAPI</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="dusakabin">
                                    <label for="dusakabin" class="ml-2 mb-0">DUŞAKABİN</label>
                                </div>
                            </div>
                        
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="intercom">
                                    <label for="intercom" class="ml-2 mb-0">İNTERCOM</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="jakuzi">
                                    <label for="jakuzi" class="ml-2 mb-0">JAKUZİ</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="msd">
                                    <label for="msd" class="ml-2 mb-0">M.S.D.</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="jenerator">
                                    <label for="jenerator" class="ml-2 mb-0">JENERATÖR</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="mutfak-d">
                                    <label for="mutfak-d" class="ml-2 mb-0">MUTFAK D.</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="sauna">
                                    <label for="sauna" class="ml-2 mb-0">SAUNA</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="seramik-z">
                                    <label for="seramik-z" class="ml-2 mb-0">SERAMİK Z.</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="su-deposu">
                                    <label for="su-deposu" class="ml-2 mb-0">SU DEPOSU</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="somine">
                                    <label for="somine" class="ml-2 mb-0">ŞÖMİNE</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="teras">
                                    <label for="teras" class="ml-2 mb-0">TERAS</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="guvenlik">
                                    <label for="guvenlik" class="ml-2 mb-0">GÜVENLİK</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="gonme-dolap">
                                    <label for="gonme-dolap" class="ml-2 mb-0">GÖNME DOLAP</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="kablo-tv">
                                    <label for="kablo-tv" class="ml-2 mb-0">KABLO TV</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="mutfak-l">
                                    <label for="mutfak-l" class="ml-2 mb-0">MUTFAK L.</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="otopark">
                                    <label for="otopark" class="ml-2 mb-0">OTOPARK</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="gor-diafon">
                                    <label for="gor-diafon" class="ml-2 mb-0">GÖR. DİAFON</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="kiler">
                                    <label for="kiler" class="ml-2 mb-0">KİLER</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="oyun-parki">
                                    <label for="oyun-parki" class="ml-2 mb-0">OYUN PARKI</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="hidrofor">
                                    <label for="hidrofor" class="ml-2 mb-0">HİDROFOR</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="klima">
                                    <label for="klima" class="ml-2 mb-0">KLİMA</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="pvc">
                                    <label for="pvc" class="ml-2 mb-0">PVC</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="hilton-banyo">
                                    <label for="hilton-banyo" class="ml-2 mb-0">HİLTON BANYON</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="kombi">
                                    <label for="kombi" class="ml-2 mb-0">KOMBİ</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="panjur">
                                    <label for="panjur" class="ml-2 mb-0">PANJUR</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="isicam">
                                    <label for="isicam" class="ml-2 mb-0">ISICAM</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="laminant-z">
                                    <label for="laminant-z" class="ml-2 mb-0">LAMİNANT Z.</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="parke">
                                    <label for="parke" class="ml-2 mb-0">PARKE</label>
                                </div>
                            </div>
                            
                            <!-- Devam eden checkbox ve etiket yapısını ekleyin -->
                            <div class="d-flex b-estate-form mb-2">
                                <!-- Örnek: -->
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="yangin-m">
                                    <label for="yangin-m" class="ml-2 mb-0">YANGIN M.</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="yuzme-havuzu">
                                    <label for="yuzme-havuzu" class="ml-2 mb-0">YÜZME H.</label>
                                </div>
                                <div class="form-group d-flex col-md-4  mt-2 mb-2" style="align-items: center;">
                                    <input type="checkbox" name="" id="wifi">
                                    <label for="wifi" class="ml-2 mb-0">Wi-Fi</label>
                                </div>
                            </div>
                        
                            <!-- Diğer özellikleri eklemek için yukarıdaki örnek yapıyı kullanın -->
                        
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="w-100 btn btn-primary">Sat/Kirala</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

