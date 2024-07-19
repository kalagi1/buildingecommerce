<div>
    <div class="container">

        <div class="watermark"></div>

        <div class="row mb-3" style="align-items: center">
            <div class="col-md-8">
                <div class="headings-2 pt-0">
                    <div class="pro-wrapper" style="width: 100%; justify-content: space-between;">
                        <div class="detail-wrapper-body">
                            <div class="listing-title-bar pb-3 pt-3">

                                <h3>
                                    {{ isset($projectData) && isset($projectData['project_title']) ? $projectData['project_title'] : '' }}

                                </h3>

                            </div>
                            <div class="mobile-action"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="headings-2 pt-0 move-gain">
                    <div class="gainStyle" style="width: 100%; justify-content: center;align-items:center;display:flex">



                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-8 blog-pots">
                <div class="row">
                    <div class="col-md-12">

                        <div id="listingDetailsSlider" class="carousel listing-details-sliders slide mb-30">
                            <div class="button-effect-div favorite-move">
                                <div class="button-effect toggle-favorite" data-housing-id="270">
                                    <i class="fa fa-heart-o"></i>
                                </div>
                            </div>
                            <div class="carousel-inner">
                                <div class="item carousel-item active" data-slide-number="0">
                                    <a href="{{ $projectData['cover_image_imagex'] }}" data-lightbox="project-images">
                                        <img src="{{ $projectData['cover_image_imagex'] }}" class="img-fluid"
                                            alt="Kapak Fotoğrafı">
                                    </a>
                                </div>

                                @foreach ($projectData['gallery_imagesx'] as $index => $image)
                                    <div class="item carousel-item" data-slide-number="{{ $index + 1 }}">
                                        <a href="{{ $image }}" data-lightbox="project-images">
                                            <img src="{{ $image }}" class="img-fluid" alt="Galeri Görseli">
                                        </a>
                                    </div>
                                @endforeach
                            </div>



                            <div class="listingDetailsSliderNav mt-3 d-flex">
                                {{-- Kapak Görseli --}}
                                <div class="item active" style="margin: 10px; cursor: pointer">
                                    <a id="carousel-selector-0" data-slide-to="0" data-target="#listingDetailsSlider">
                                        <img src="{{ $projectData['cover_image_imagex'] }}"
                                            class="img-fluid carousel-indicator-image" alt="listing-small">
                                    </a>
                                </div>
                                {{-- Diğer Görseller --}}
                                @foreach ($projectData['gallery_imagesx'] as $index => $image)
                                    <div class="item" style="margin: 10px; cursor: pointer">
                                        <a id="carousel-selector-{{ $index + 1 }}"
                                            data-slide-to="{{ $index + 1 }}" data-target="#listingDetailsSlider">
                                            <img src="{{ $image }}" class="img-fluid carousel-indicator-image"
                                                alt="listing-small">
                                        </a>
                                    </div>
                                @endforeach

                            </div>
                            <nav aria-label="Page navigation example" style="margin-top: 7px">
                                <ul class="pagination">
                                    <li class="page-item page-item-left"><a class="page-link" href="#"><i
                                                class="fas fa-angle-left"></i></a></li>
                                    <li class="page-item page-item-middle"><a class="page-link"
                                            href="#">1/{{ isset($projectData['gallery_imagesx']) && count($projectData['gallery_imagesx']) }}</a>
                                    </li>
                                    <li class="page-item page-item-right"><a class="page-link" href="#"><i
                                                class="fas fa-angle-right"></i></a></li>
                                </ul>
                            </nav>
                        </div>



                    </div>
                </div>


            </div>
            <aside class="col-md-4  car">
                <div class="single widget">
                    {{-- <!-- Teklif Ver Modal -->
                    <div class="modal fade" id="bidModal" tabindex="-1" role="dialog"
                        aria-labelledby="bidModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="bidModalLabel">Pazarlık Yap</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Kapat">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form action="http://127.0.0.1:8000/bids/270" method="POST">
                                        <input type="hidden" name="_token"
                                            value="8DcBjpeieS4d2aWk8uRWj0m50iVJiPTq0VFb1sgq" autocomplete="off">
                                        <div class="form-group">
                                            <label for="bid_amount">Teklifiniz:</label>
                                            <input type="text" name="bid_amount" class="form-control"
                                                id="newPrice" required="">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Gönder</button>
                                    </form>
                                    <p class="mt-3">Tekliflerin 24 saat geçerliliği bulunmaktadır. Günlük Kalan
                                        Hakkınız: 40</p>

                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Fiyat Güncelleme Modal -->
                    <div class="modal fade" id="priceUpdateModal" tabindex="-1" role="dialog"
                        aria-labelledby="priceUpdateModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="priceUpdateModalLabel">Fiyat Güncelleme</h5>
                                    <button type="button" class="close priceUpdateModalLabelClose"
                                        data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Fiyatı güncellerseniz ilanınız onaya düşecektir.</p>
                                    <form id="price-update-form" method="POST"
                                        action="http://127.0.0.1:8000/housing/270/update-price"
                                        onsubmit="return false;">
                                        <input type="hidden" name="_token"
                                            value="8DcBjpeieS4d2aWk8uRWj0m50iVJiPTq0VFb1sgq" autocomplete="off">
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="form-group">
                                            <label for="new-price" class="q-label">Yeni Fiyat: </label><br>
                                            <input type="text" class="modal-input" id="new-price"
                                                name="new_price" placeholder="Yeni Fiyat">
                                        </div>
                                        <button type="button" class="btn btn-primary"
                                            id="confirm-price-update">Güncelle</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Onay Modal -->
                    <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                        aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Fiyatı Onayla</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p id="confirmation-message"></p>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">İptal</button>
                                    <button type="button" class="btn btn-primary" id="confirm-update-button">Evet,
                                        Güncelle</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        document.getElementById('confirm-price-update').addEventListener('click', function() {
                            var newPrice = document.getElementById('new-price').value;
                            document.getElementById('confirmation-message').innerText = 'Fiyatı ' + newPrice +
                                ' ₺ olarak güncellemek istediğinizden emin misiniz?';

                            // Close the price update modal
                            document.querySelector(".priceUpdateModalLabelClose").click();

                            // Open the confirmation modal
                            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
                            confirmationModal.show();
                        });

                        document.getElementById('confirm-update-button').addEventListener('click', function() {
                            document.getElementById('price-update-form').onsubmit = function() {
                                return true;
                            };
                            document.getElementById('price-update-form').submit();
                        });
                    </script>


                    <div class="modal fade" id="takasModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Takas Formu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form action="http://127.0.0.1:8000/form-kaydet" method="POST"
                                        enctype="multipart/form-data" id="takasFormu" novalidate="novalidate">
                                        <input type="hidden" name="_token"
                                            value="8DcBjpeieS4d2aWk8uRWj0m50iVJiPTq0VFb1sgq" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="ad">Ad:</label>
                                                <input class="formInput" type="text" id="ad"
                                                    name="ad" required="" aria-required="true">
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="soyad">Soyadınız:</label>
                                                <input class="formInput" type="text" id="soyad"
                                                    name="soyad" required="" aria-required="true">
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="telefon">Telefon
                                                    Numaranız:</label>
                                                <input class="formInput" type="number" id="telefon"
                                                    name="telefon" required="" maxlength="10"
                                                    aria-required="true">
                                                <span id="error_message" class="error-message"></span>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="email">E-mail:</label>
                                                <input class="formInput" type="email" id="email"
                                                    name="email" required="" aria-required="true">
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="sehir">Şehir:</label>
                                                <select class="formInput" id="sehir" name="sehir"
                                                    required="" aria-required="true">
                                                    <option value="">Şehir Seçiniz</option>
                                                    <option value="1">
                                                        ADANA</option>
                                                    <option value="2">
                                                        ADIYAMAN</option>
                                                    <option value="3">
                                                        AFYONKARAHİSAR</option>
                                                    <option value="4">
                                                        AĞRI</option>
                                                    <option value="5">
                                                        AMASYA</option>
                                                    <option value="6">
                                                        ANKARA</option>
                                                    <option value="7">
                                                        ANTALYA</option>
                                                    <option value="8">
                                                        ARTVİN</option>
                                                    <option value="9">
                                                        AYDIN</option>
                                                    <option value="10">
                                                        BALIKESİR</option>
                                                    <option value="11">
                                                        BİLECİK</option>
                                                    <option value="12">
                                                        BİNGÖL</option>
                                                    <option value="13">
                                                        BİTLİS</option>
                                                    <option value="14">
                                                        BOLU</option>
                                                    <option value="15">
                                                        BURDUR</option>
                                                    <option value="16">
                                                        BURSA</option>
                                                    <option value="17">
                                                        ÇANAKKALE</option>
                                                    <option value="18">
                                                        ÇANKIRI</option>
                                                    <option value="19">
                                                        ÇORUM</option>
                                                    <option value="20">
                                                        DENİZLİ</option>
                                                    <option value="21">
                                                        DİYARBAKIR</option>
                                                    <option value="22">
                                                        EDİRNE</option>
                                                    <option value="23">
                                                        ELAZIĞ</option>
                                                    <option value="24">
                                                        ERZİNCAN</option>
                                                    <option value="25">
                                                        ERZURUM</option>
                                                    <option value="26">
                                                        ESKİŞEHİR</option>
                                                    <option value="27">
                                                        GAZİANTEP</option>
                                                    <option value="28">
                                                        GİRESUN</option>
                                                    <option value="29">
                                                        GÜMÜŞHANE</option>
                                                    <option value="30">
                                                        HAKKARİ</option>
                                                    <option value="31">
                                                        HATAY</option>
                                                    <option value="32">
                                                        ISPARTA</option>
                                                    <option value="33">
                                                        MERSİN</option>
                                                    <option value="34">
                                                        İSTANBUL</option>
                                                    <option value="35">
                                                        İZMİR</option>
                                                    <option value="36">
                                                        KARS</option>
                                                    <option value="37">
                                                        KASTAMONU</option>
                                                    <option value="38">
                                                        KAYSERİ</option>
                                                    <option value="39">
                                                        KIRKLARELİ</option>
                                                    <option value="40">
                                                        KIRŞEHİR</option>
                                                    <option value="41">
                                                        KOCAELİ</option>
                                                    <option value="42">
                                                        KONYA</option>
                                                    <option value="43">
                                                        KÜTAHYA</option>
                                                    <option value="44">
                                                        MALATYA</option>
                                                    <option value="45">
                                                        MANİSA</option>
                                                    <option value="46">
                                                        KAHRAMANMARAŞ</option>
                                                    <option value="47">
                                                        MARDİN</option>
                                                    <option value="48">
                                                        MUĞLA</option>
                                                    <option value="49">
                                                        MUŞ</option>
                                                    <option value="50">
                                                        NEVŞEHİR</option>
                                                    <option value="51">
                                                        NİĞDE</option>
                                                    <option value="52">
                                                        ORDU</option>
                                                    <option value="53">
                                                        RİZE</option>
                                                    <option value="54">
                                                        SAKARYA</option>
                                                    <option value="55">
                                                        SAMSUN</option>
                                                    <option value="56">
                                                        SİİRT</option>
                                                    <option value="57">
                                                        SİNOP</option>
                                                    <option value="58">
                                                        SİVAS</option>
                                                    <option value="59">
                                                        TEKİRDAĞ</option>
                                                    <option value="60">
                                                        TOKAT</option>
                                                    <option value="61">
                                                        TRABZON</option>
                                                    <option value="62">
                                                        TUNCELİ</option>
                                                    <option value="63">
                                                        ŞANLIURFA</option>
                                                    <option value="64">
                                                        UŞAK</option>
                                                    <option value="65">
                                                        VAN</option>
                                                    <option value="66">
                                                        YOZGAT</option>
                                                    <option value="67">
                                                        ZONGULDAK</option>
                                                    <option value="68">
                                                        AKSARAY</option>
                                                    <option value="69">
                                                        BAYBURT</option>
                                                    <option value="70">
                                                        KARAMAN</option>
                                                    <option value="71">
                                                        KIRIKKALE</option>
                                                    <option value="72">
                                                        BATMAN</option>
                                                    <option value="73">
                                                        ŞIRNAK</option>
                                                    <option value="74">
                                                        BARTIN</option>
                                                    <option value="75">
                                                        ARDAHAN</option>
                                                    <option value="76">
                                                        IĞDIR</option>
                                                    <option value="77">
                                                        YALOVA</option>
                                                    <option value="78">
                                                        KARABÜK</option>
                                                    <option value="79">
                                                        KİLİS</option>
                                                    <option value="80">
                                                        OSMANİYE</option>
                                                    <option value="81">
                                                        DÜZCE</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label" for="ilce">İlçe:</label>
                                                <select class="formInput" id="ilce" name="ilce"
                                                    disabled="" required="" aria-required="true">
                                                    <option value="">İlçe Seçiniz</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 col-12">
                                                <label class="form-label" for="takas_tercihi">Takas
                                                    Tercihiniz:</label>
                                                <select class="formInput" id="takas_tercihi" name="takas_tercihi"
                                                    required="" aria-required="true">
                                                    <option value="">Seçiniz</option>
                                                    <option value="emlak">Emlak</option>
                                                    <option value="araç">Araç</option>
                                                    <option value="barter">Barter</option>
                                                    <option value="diğer">Diğer</option>
                                                </select>
                                            </div>


                                            <div id="digeryse" style="display: none;" class="col-md-12 col-12">
                                                <label class="form-label" for="diger_detay">Takas ile ilgili
                                                    ürün/hizmet detayı:</label>
                                                <textarea class="formInput" id="diger_detay" name="diger_detay"></textarea>
                                            </div>

                                            <div id="barteryse" style="display: none;" class="col-md-12 col-12">
                                                <label class="form-label" for="barter_detay">Lütfen barter
                                                    durumunuz ile ilgili detaylı bilgileri
                                                    giriniz:</label>
                                                <textarea class="formInput" id="barter_detay" name="barter_detay"></textarea>
                                            </div>

                                            <div id="emlakyse" style="display: none;" class="col-md-12 col-12">
                                                <label class="form-label" for="emlak_tipi">Emlak Tipi:</label>
                                                <select class="formInput" id="emlak_tipi" name="emlak_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="konut">Konut</option>
                                                    <option value="arsa">Arsa</option>
                                                    <option value="işyeri">İşyeri</option>
                                                </select>
                                            </div>

                                            <div id="konutyse" style="display: none;" class="col-md-12 col-12">
                                                <label class="form-label" for="konut_tipi">Konut Tipi:</label>
                                                <select class="formInput" id="konut_tipi" name="konut_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="daire">Daire</option>
                                                    <option value="villa">Villa</option>
                                                    <option value="residance">Residance</option>
                                                    <option value="prefabrik_ev">Prefabrik Ev</option>
                                                    <option value="çiftlik_evi">Çiftlik Evi</option>
                                                </select>

                                                <label for="oda_sayisi">Oda Sayısı</label>
                                                <select class="form-select formInput"
                                                    aria-label="Default select example" id="oda_sayisi"
                                                    name="oda_sayisi">
                                                    <option selected="">Seçiniz</option>
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

                                                <label class="form-label" for="konut_tipi">Konut Yaşı:</label>
                                                <select class="formInput" id="konut_yasi" name="konut_yasi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5-10">5-10</option>
                                                    <option value="11-15">11-15</option>
                                                    <option value="16-20">16-20</option>
                                                    <option value="20 ve Üzeri">20 ve Üzeri</option>
                                                </select>

                                                <input class="formInput" type="hidden" id="store_id"
                                                    name="store_id" value="357">

                                                <label class="form-label" for="kullanim_durumu">Kullanım
                                                    Durumu:</label>
                                                <select class="formInput" id="kullanim_durumu"
                                                    name="kullanim_durumu">
                                                    <option value="">Seçiniz</option>
                                                    <option value="kiracılı">Kiracılı</option>
                                                    <option value="boş">Boş</option>
                                                    <option value="mülk_sahibi">Mülk Sahibi</option>
                                                </select>

                                                <label class="form-label" for="konut_satis_rakami">Düşündüğünüz
                                                    Satış
                                                    Rakamı:</label>
                                                <input class="formInput" type="text" id="konut_satis_rakami"
                                                    name="konut_satis_rakami" min="0">

                                                <label class="form-label" for="tapu_belgesi">Tapu Belgesi
                                                    Yükleyiniz:</label>
                                                <input class="formInput" type="file" id="tapu_belgesi"
                                                    name="tapu_belgesi" accept=".pdf,.doc,.docx">
                                            </div>

                                            <div id="arsayse" style="display: none;" class="col-md-12 col-12">

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="form-label" for="arsa_il">Arsa
                                                            İl:</label>
                                                        <select class="formInput" id="arsa_il" name="arsa_il">
                                                            <option value="">Şehir Seçiniz</option>
                                                            <option value="1">
                                                                ADANA</option>
                                                            <option value="2">
                                                                ADIYAMAN</option>
                                                            <option value="3">
                                                                AFYONKARAHİSAR</option>
                                                            <option value="4">
                                                                AĞRI</option>
                                                            <option value="5">
                                                                AMASYA</option>
                                                            <option value="6">
                                                                ANKARA</option>
                                                            <option value="7">
                                                                ANTALYA</option>
                                                            <option value="8">
                                                                ARTVİN</option>
                                                            <option value="9">
                                                                AYDIN</option>
                                                            <option value="10">
                                                                BALIKESİR</option>
                                                            <option value="11">
                                                                BİLECİK</option>
                                                            <option value="12">
                                                                BİNGÖL</option>
                                                            <option value="13">
                                                                BİTLİS</option>
                                                            <option value="14">
                                                                BOLU</option>
                                                            <option value="15">
                                                                BURDUR</option>
                                                            <option value="16">
                                                                BURSA</option>
                                                            <option value="17">
                                                                ÇANAKKALE</option>
                                                            <option value="18">
                                                                ÇANKIRI</option>
                                                            <option value="19">
                                                                ÇORUM</option>
                                                            <option value="20">
                                                                DENİZLİ</option>
                                                            <option value="21">
                                                                DİYARBAKIR</option>
                                                            <option value="22">
                                                                EDİRNE</option>
                                                            <option value="23">
                                                                ELAZIĞ</option>
                                                            <option value="24">
                                                                ERZİNCAN</option>
                                                            <option value="25">
                                                                ERZURUM</option>
                                                            <option value="26">
                                                                ESKİŞEHİR</option>
                                                            <option value="27">
                                                                GAZİANTEP</option>
                                                            <option value="28">
                                                                GİRESUN</option>
                                                            <option value="29">
                                                                GÜMÜŞHANE</option>
                                                            <option value="30">
                                                                HAKKARİ</option>
                                                            <option value="31">
                                                                HATAY</option>
                                                            <option value="32">
                                                                ISPARTA</option>
                                                            <option value="33">
                                                                MERSİN</option>
                                                            <option value="34">
                                                                İSTANBUL</option>
                                                            <option value="35">
                                                                İZMİR</option>
                                                            <option value="36">
                                                                KARS</option>
                                                            <option value="37">
                                                                KASTAMONU</option>
                                                            <option value="38">
                                                                KAYSERİ</option>
                                                            <option value="39">
                                                                KIRKLARELİ</option>
                                                            <option value="40">
                                                                KIRŞEHİR</option>
                                                            <option value="41">
                                                                KOCAELİ</option>
                                                            <option value="42">
                                                                KONYA</option>
                                                            <option value="43">
                                                                KÜTAHYA</option>
                                                            <option value="44">
                                                                MALATYA</option>
                                                            <option value="45">
                                                                MANİSA</option>
                                                            <option value="46">
                                                                KAHRAMANMARAŞ</option>
                                                            <option value="47">
                                                                MARDİN</option>
                                                            <option value="48">
                                                                MUĞLA</option>
                                                            <option value="49">
                                                                MUŞ</option>
                                                            <option value="50">
                                                                NEVŞEHİR</option>
                                                            <option value="51">
                                                                NİĞDE</option>
                                                            <option value="52">
                                                                ORDU</option>
                                                            <option value="53">
                                                                RİZE</option>
                                                            <option value="54">
                                                                SAKARYA</option>
                                                            <option value="55">
                                                                SAMSUN</option>
                                                            <option value="56">
                                                                SİİRT</option>
                                                            <option value="57">
                                                                SİNOP</option>
                                                            <option value="58">
                                                                SİVAS</option>
                                                            <option value="59">
                                                                TEKİRDAĞ</option>
                                                            <option value="60">
                                                                TOKAT</option>
                                                            <option value="61">
                                                                TRABZON</option>
                                                            <option value="62">
                                                                TUNCELİ</option>
                                                            <option value="63">
                                                                ŞANLIURFA</option>
                                                            <option value="64">
                                                                UŞAK</option>
                                                            <option value="65">
                                                                VAN</option>
                                                            <option value="66">
                                                                YOZGAT</option>
                                                            <option value="67">
                                                                ZONGULDAK</option>
                                                            <option value="68">
                                                                AKSARAY</option>
                                                            <option value="69">
                                                                BAYBURT</option>
                                                            <option value="70">
                                                                KARAMAN</option>
                                                            <option value="71">
                                                                KIRIKKALE</option>
                                                            <option value="72">
                                                                BATMAN</option>
                                                            <option value="73">
                                                                ŞIRNAK</option>
                                                            <option value="74">
                                                                BARTIN</option>
                                                            <option value="75">
                                                                ARDAHAN</option>
                                                            <option value="76">
                                                                IĞDIR</option>
                                                            <option value="77">
                                                                YALOVA</option>
                                                            <option value="78">
                                                                KARABÜK</option>
                                                            <option value="79">
                                                                KİLİS</option>
                                                            <option value="80">
                                                                OSMANİYE</option>
                                                            <option value="81">
                                                                DÜZCE</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label" for="arsa_ilce">Arsa
                                                            İlçe:</label>
                                                        <select class="formInput" id="arsa_ilce" name="arsa_ilce"
                                                            disabled="">
                                                            <option value="">İlçe Seçiniz</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label" for="arsa_mahalle">Arsa
                                                            Mahalle:</label>
                                                        <select class="formInput" id="arsa_mahalle"
                                                            name="arsa_mahalle" disabled="">
                                                            <option value="">Mahalle Seçiniz</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label class="form-label" for="ada_parsel">Ada Parsel
                                                    Bilgisi:</label>
                                                <input class="formInput" type="text" id="ada_parsel"
                                                    name="ada_parsel">

                                                <label class="form-label" for="imar_durumu">Arsa İmar
                                                    Durumu:</label>
                                                <select class="formInput" id="imar_durumu" name="imar_durumu">
                                                    <option value="">Seçiniz</option>
                                                    <option value="villa">Villa</option>
                                                    <option value="konut">Konut</option>
                                                    <option value="turizm">Turizm Amaçlı Kiralama</option>
                                                    <option value="sanayi">Sanayi</option>
                                                    <option value="ticari">Ticari</option>
                                                    <option value="bağ_bahçe">Bağ Bahçe</option>
                                                    <option value="tarla">Tarla</option>
                                                </select>

                                                <label class="form-label" for="satis_rakami">Düşündüğünüz
                                                    Satış Rakamı:</label>
                                                <input class="formInput" type="text" id="satis_rakami"
                                                    name="satis_rakami" min="0">
                                            </div>

                                            <div id="aracyse" style="display: none;" class="col-md-12 col-12">

                                                <label class="form-label" for="arac_model_yili">Araç Model
                                                    Yılı:</label>
                                                <select class="formInput" id="arac_model_yili"
                                                    name="arac_model_yili">
                                                    <option value="">Model Yılı Seçiniz</option>
                                                    <option value="2024">
                                                        2024</option>
                                                    <option value="2023">
                                                        2023</option>
                                                    <option value="2022">
                                                        2022</option>
                                                    <option value="2021">
                                                        2021</option>
                                                    <option value="2020">
                                                        2020</option>
                                                    <option value="2019">
                                                        2019</option>
                                                    <option value="2018">
                                                        2018</option>
                                                    <option value="2017">
                                                        2017</option>
                                                    <option value="2016">
                                                        2016</option>
                                                    <option value="2015">
                                                        2015</option>
                                                    <option value="2014">
                                                        2014</option>
                                                    <option value="2013">
                                                        2013</option>
                                                    <option value="2012">
                                                        2012</option>
                                                    <option value="2011">
                                                        2011</option>
                                                    <option value="2010">
                                                        2010</option>
                                                    <option value="2009">
                                                        2009</option>
                                                    <option value="2008">
                                                        2008</option>
                                                    <option value="2007">
                                                        2007</option>
                                                    <option value="2006">
                                                        2006</option>
                                                    <option value="2005">
                                                        2005</option>
                                                    <option value="2004">
                                                        2004</option>
                                                </select>


                                                <label class="form-label" for="arac_markasi">Araç
                                                    Markası:</label>
                                                <select class="formInput" name="arac_markasi" id="arac_markasi">
                                                    <option value="">Seçiniz...</option>
                                                    <option value="Alfa Romeo">Alfa Romeo</option>
                                                    <option value="Aston Martin">Aston Martin</option>
                                                    <option value="Audi">Audi</option>
                                                    <option value="Bentley">Bentley</option>
                                                    <option value="BMW">BMW</option>
                                                    <option value="Bugatti">Bugatti</option>
                                                    <option value="Buick">Buick</option>
                                                    <option value="Cadillac">Cadillac</option>
                                                    <option value="Chery">Chery</option>
                                                    <option value="Chevrolet">Chevrolet</option>
                                                    <option value="Chrysler">Chrysler</option>
                                                    <option value="Citroen">Citroen</option>
                                                    <option value="Cupra">Cupra</option>
                                                    <option value="Dacia">Dacia</option>
                                                    <option value="DS Automobiles">DS Automobiles</option>
                                                    <option value="Daewoo">Daewoo</option>
                                                    <option value="Daihatsu">Daihatsu</option>
                                                    <option value="Dodge">Dodge</option>
                                                    <option value="Ferrari">Ferrari</option>
                                                    <option value="Fiat">Fiat</option>
                                                    <option value="Ford">Ford</option>
                                                    <option value="Geely">Geely</option>
                                                    <option value="Honda">Honda</option>
                                                    <option value="Hyundai">Hyundai</option>
                                                    <option value="Infiniti">Infiniti</option>
                                                    <option value="Isuzu">Isuzu</option>
                                                    <option value="Iveco">Iveco</option>
                                                    <option value="Jaguar">Jaguar</option>
                                                    <option value="Jeep">Jeep</option>
                                                    <option value="Kia">Kia</option>
                                                    <option value="Lada">Lada</option>
                                                    <option value="Lamborghini">Lamborghini</option>
                                                    <option value="Lancia">Lancia</option>
                                                    <option value="Land-rover">Land-rover</option>
                                                    <option value="Leapmotor">Leapmotor</option>
                                                    <option value="Lexus">Lexus</option>
                                                    <option value="Lincoln">Lincoln</option>
                                                    <option value="Lotus">Lotus</option>
                                                    <option value="Maserati">Maserati</option>
                                                    <option value="Mazda">Mazda</option>
                                                    <option value="McLaren">McLaren</option>
                                                    <option value="Mercedes-Benz">Mercedes-Benz</option>
                                                    <option value="MG">MG</option>
                                                    <option value="Mini">Mini</option>
                                                    <option value="Mitsubishi">Mitsubishi</option>
                                                    <option value="Nissan">Nissan</option>
                                                    <option value="Opel">Opel</option>
                                                    <option value="Peugeot">Peugeot</option>
                                                    <option value="Porsche">Porsche</option>
                                                    <option value="Proton">Proton</option>
                                                    <option value="Renault">Renault</option>
                                                    <option value="Rolls Royce">Rolls Royce</option>
                                                    <option value="Rover">Rover</option>
                                                    <option value="Saab">Saab</option>
                                                    <option value="Seat">Seat</option>
                                                    <option value="Skoda">Skoda</option>
                                                    <option value="Smart">Smart</option>
                                                    <option value="Ssangyong">Ssangyong</option>
                                                    <option value="Subaru">Subaru</option>
                                                    <option value="Suzuki">Suzuki</option>
                                                    <option value="Tata">Tata</option>
                                                    <option value="Tesla">Tesla</option>
                                                    <option value="Tofaş">Tofaş</option>
                                                    <option value="Toyota">Toyota</option>
                                                    <option value="Volkswagen">Volkswagen</option>
                                                    <option value="Volvo">Volvo</option>
                                                    <option value="Voyah">Voyah</option>
                                                    <option value="Yudo">Yudo</option>
                                                </select>

                                                <label class="form-label" for="yakit_tipi">Yakıt Tipi:</label>
                                                <select class="formInput" id="yakit_tipi" name="yakit_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="benzin">Benzin</option>
                                                    <option value="dizel">Dizel</option>
                                                    <option value="lpg">LPG</option>
                                                    <option value="elektrik">Elektrik</option>
                                                </select>

                                                <label class="form-label" for="vites_tipi">Vites Tipi:</label>
                                                <select class="formInput" id="vites_tipi" name="vites_tipi">
                                                    <option value="">Seçiniz</option>
                                                    <option value="manuel">Manuel</option>
                                                    <option value="otomatik">Otomatik</option>
                                                </select>

                                                <label class="form-label" for="arac_satis_rakami">Satış
                                                    Rakamı:</label>
                                                <input class="formInput" type="text" id="arac_satis_rakami"
                                                    name="arac_satis_rakami" min="0">

                                                <label class="form-label" for="ruhsat_belgesi">Ruhsat
                                                    Belgesi
                                                    Yükleyiniz:</label>
                                                <input class="formInput" type="file" id="ruhsat_belgesi"
                                                    name="ruhsat_belgesi" accept=".pdf,.doc,.docx">
                                            </div>

                                            <div id="isyeriyse" style="display: none;" class="mb-3 col-md-12 col-12">

                                                <label for="ticari_bilgiler" class="form-label">Ticari ile
                                                    ilgili Bilgileri Giriniz:</label>
                                                <textarea class="formInput" id="ticari_bilgiler" name="ticari_bilgiler"></textarea>

                                                <label for="isyeri_satis_rakami" class="form-label">Düşündüğünüz
                                                    Satış
                                                    Rakamı:</label>
                                                <input type="text" class="formInput" id="isyeri_satis_rakami"
                                                    name="isyeri_satis_rakami" min="0">
                                            </div>

                                        </div>

                                        <button type="submit"
                                            style="background-color: #ea2a28; color: white; padding: 10px; border: none;width:150px;margin-top:20px">Başvur</button>
                                        <button type="button" data-bs-dismiss="modal"
                                            style="background-color: black; color: white; padding: 10px; border: none;width:150px;margin-top:20px">Kapat</button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="mt-5 mb-5">


                    </div> --}}

                    <div class="moveStore">
                        <div class="widget-boxed removeClass mb-5">
                            <div class="widget-boxed-body pt-0">
                                <div class="sidebar-widget author-widget2">
                                    <table class="table">
                                        <tbody>

                                            <tr style="border-top: none !important">
                                                <td style="border-top: none !important">
                                                    <span class="det" style="color: #EA2B2E !important;">
                                                        @if (isset($city) || isset($county) || isset($neighbour))
                                                            @if (isset($city))
                                                                {{ strtoupper($city->title) }}
                                                            @endif
                                                            @if (isset($county))
                                                                / {{ strtoupper($county->ilce_title) }}
                                                            @endif
                                                            @if (isset($neighbour))
                                                                / {{ strtoupper($neighbour->mahalle_title) }}
                                                            @endif
                                                        @else
                                                            Konum bilgisi yok
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span> İlan No :</span>
                                                    <span class="det" style="color:#274abb;">
                                                        {{ isset($newHousingId) ? $newHousingId : '' }}

                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span> İlan Tarihi :</span>
                                                    <span class="det" style="color:#274abb;">
                                                        {{ \Carbon\Carbon::now()->locale('tr')->translatedFormat('d F Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span>
                                                        @if (isset($user))
                                                            @if ($user->type == '1')
                                                                Sahibinden:
                                                            @else
                                                                Mağaza:
                                                            @endif
                                                        @endif


                                                    </span>
                                                    <span class="det text-wrap" style="color:#274abb;">
                                                        {{ isset($user) ? $user->name : '' }}

                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <span> Kimden :</span>
                                                    <span class="det text-wrap" style="color:#274abb;">
                                                        @if (isset($user))
                                                            {{ $user->type == '1' ? 'Bireysel Kullanıcı' : ($user->corporate_type == 'Emlak Ofisi' ? 'Gayrimenkul Ofisi' : $user->corporate_type) }}
                                                        @endif
                                                    </span>

                                                </td>
                                            </tr>

                                            @if (isset($user))
                                                @if ($user->type == '1')
                                                    <tr>
                                                        <td>
                                                            Cep :
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel:{{ isset($user) ? $user->mobile_phone : '' }}">
                                                                    {{ isset($user) ? $user->mobile_phone : '' }}
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>
                                                            İş :
                                                            <span class="det">
                                                                <a style="text-decoration: none;color:#274abb;"
                                                                    href="tel: {{ isset($user) ? $user->phone : '' }}">
                                                                    {{ isset($user) ? $user->phone : '' }}
                                                                </a>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endif

                                            @endif





                                            <tr>
                                                <td>
                                                    İlan Tipi :
                                                    <span class="det">
                                                        {{ isset($housingTypeParent1) ? $housingTypeParent1->title : '' }}

                                                        {{ isset($housingTypeParent2) ? $housingTypeParent2->title : '' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    E-Posta :
                                                    <span class="det">
                                                        <a style="text-decoration: none;color:inherit"
                                                            href="mailto:{{ isset($user) ? $user->email : '' }}">
                                                            {{ isset($user) ? $user->email : '' }}</a>
                                                    </span>

                                                </td>
                                            </tr>
                                            @if (isset($projectData['create_company']) && $projectData['create_company'])
                                                <tr>
                                                    <td>
                                                        Yapıcı Firma :
                                                        <span class="det">
                                                            {{ $projectData['create_company'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['island']) && $projectData['island'])
                                                <tr>
                                                    <td>
                                                        Ada :
                                                        <span class="det">
                                                            {{ $projectData['island'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['parcel']) && $projectData['parcel'])
                                                <tr>
                                                    <td>
                                                        Parsel :
                                                        <span class="det">
                                                            {{ $projectData['parcel'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['start_date']) && $projectData['start_date'])
                                                <tr>
                                                    <td>
                                                        Başlangıç Tarihi :
                                                        <span class="det">
                                                            {{ $projectData['start_date'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['end_date']) && $projectData['end_date'])
                                                <tr>
                                                    <td>
                                                        Bitiş Tarihi :
                                                        <span class="det">
                                                            {{ $projectData['end_date'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            @if (isset($projectData['total_project_area']) && $projectData['total_project_area'])
                                                <tr>
                                                    <td>
                                                        Toplam Proje Alanı m2 :
                                                        <span class="det">
                                                            {{ $projectData['total_project_area'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td>
                                                    Toplam Konut Sayısı :
                                                    <span class="det">
                                                        {{ isset($roomCount) ? $roomCount : '' }}

                                                    </span>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Satılan Konut Sayısı :
                                                    <span class="det">
                                                        0
                                                    </span>

                                                </td>
                                            </tr>










                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>

            </aside>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link  active " id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                aria-selected="true">Projedeki Konutlar</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false"
                                tabindex="-1">Açıklama</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                type="button" role="tab" aria-controls="profile" aria-selected="false"
                                tabindex="-1">Özellikler</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#map"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                tabindex="-1">Harita</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                                type="button" role="tab" aria-controls="contact" aria-selected="false"
                                tabindex="-1">Yorumlar</button>
                        </li>


                    </ul>

                    <div class="tab-content inner-pages" id="myTabContent" style="display: block;">

                        <div class="tab-pane properties-right list fade blog-info details mb-30  show active "
                            id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="button-tabs">
                                <ul class="tabs">
                                    @if (isset($blocks) && $haveBlocks)
                                        @foreach ($blocks as $index => $block)
                                            <li class="nav-item-block  @if ($index == 0) active @endif"
                                                role="presentation">
                                                <div class="tab-title">
                                                    <span>{{ $block['name'] }}</span>
                                                </div>
                                            </li>
                                        @endforeach

                                    @endif

                                </ul>
                            </div>

                            @if (isset($blocks) && is_array($blocks) && isset($blocks[0]['rooms']))
                                @php
                                    $limitedRooms = array_slice($blocks[0]['rooms'], 0, $blocks[0]['roomCount']);
                                @endphp
                                @foreach ($limitedRooms as $index => $item)
                                    <div class="row project-filter-reverse blog-pots" id="project-room">
                                        <div class="col-md-12 col-12">
                                            <div class="project-card mb-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <a href="#" style="height: 100%">

                                                            <div class="d-flex" style="height: 100%;">
                                                                <div
                                                                    style="background-color: #EA2B2E !important; border-radius: 0px 8px 0px 8px; height:100%">
                                                                    <p
                                                                        style="padding: 10px; color: white; height: 100%; display: flex; align-items: center; text-align:center; ">
                                                                        No<br>

                                                                        {{ $index + 1 }}

                                                                    </p>
                                                                </div>
                                                                <div class="project-single mb-0 bb-0 aos-init aos-animate"
                                                                    data-aos="fade-up">
                                                                    <div class="button-effect-div">



                                                                        <span
                                                                            class="btn addCollection mobileAddCollection"
                                                                            data-type="project" data-project="283"
                                                                            data-id="1">
                                                                            <i class="fa fa-bookmark-o"></i>
                                                                        </span>


                                                                        <span
                                                                            class="btn toggle-project-favorite bg-white"
                                                                            data-project-housing-id="1"
                                                                            data-project-id="283">
                                                                            <i class="fa fa-heart-o"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="homes position-relative">
                                                                        <img src="{{ $item['image[]_imagex'] }}"
                                                                            alt="home-1" class="img-responsive"
                                                                            style="height: 100px !important; object-fit: cover">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>

                                                    <div class="col-lg-9 col-md-9 homes-content pb-0 mb-44 aos-init aos-animate"
                                                        data-aos="fade-up">

                                                        <div
                                                            class="row align-items-center justify-content-between mobile-position">
                                                            <div class="col-md-9">


                                                                <div class="homes-list-div"
                                                                    style="flex-direction: column !important;">


                                                                    <ul class="homes-list clearfix pb-3 d-flex projectCardList"
                                                                        style="height: 90px !important">

                                                                        @foreach (['column1', 'column2', 'column3'] as $column)
                                                                            @php
                                                                                $column_name =
                                                                                    $projectListItems[0]
                                                                                        ->{$column . '_name'} ?? '';
                                                                                $column_additional =
                                                                                    $projectListItems[0]
                                                                                        ->{$column . '_additional'} ??
                                                                                    '';
                                                                                $column_name_exists =
                                                                                    $column_name &&
                                                                                    isset($item[$column_name . '[]']);
                                                                            @endphp

                                                                            @if ($column_name_exists)
                                                                                <li
                                                                                    class="d-flex align-items-center itemCircleFont">
                                                                                    <i class="fa fa-circle circleIcon mr-1"
                                                                                        aria-hidden="true"></i>
                                                                                    <span>
                                                                                        {{ $item[$column_name . '[]'] }}
                                                                                        @if ($column_additional && is_numeric($item[$column_name . '[]']))
                                                                                            {{ $column_additional }}
                                                                                        @endif
                                                                                    </span>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach



                                                                        <li
                                                                            class="d-flex align-items-center itemCircleFont">
                                                                            <i class="fa fa-circle circleIcon mr-1"
                                                                                aria-hidden="true"></i>
                                                                            <span>
                                                                                {{ \Carbon\Carbon::now()->locale('tr')->translatedFormat('d F Y') }}
                                                                            </span>
                                                                        </li>

                                                                        <li class="the-icons mobile-hidden">
                                                                            <span style="width:100%;text-align:center">
                                                                                @php
                                                                                    $price = str_replace(
                                                                                        '.',
                                                                                        '',
                                                                                        $item['price[]'],
                                                                                    ); // Remove dots from the price string
                                                                                    $price = intval($price); // Convert the cleaned price string to an integer
                                                                                @endphp
                                                                                @if (isset($item['share_sale[]']) && isset($item['number_of_shares[]']))
                                                                                    <span class="text-center w-100">
                                                                                        1 /
                                                                                        {{ isset($item['number_of_shares[]']) ? $item['number_of_shares[]'] : null }}
                                                                                        Fiyatı
                                                                                    </span>
                                                                                    <h6
                                                                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                                                        {{ number_format($price / (isset($item['number_of_shares[]']) ? $item['number_of_shares[]'] : 1), 2, ',', '.') }}
                                                                                        ₺
                                                                                    </h6>
                                                                                @else
                                                                                    <h6
                                                                                        style="color: #274abb !important; position: relative; top: 4px; font-weight: 700">
                                                                                        {{ number_format($price, 2, ',', '.') }}
                                                                                        ₺
                                                                                    </h6>
                                                                                @endif
                                                                            </span>
                                                                        </li>




                                                                    </ul>

                                                                    @if (isset($item['share_sale[]']) && isset($item['number_of_shares[]']))
                                                                        <div class="bar-chart">
                                                                            <div class="progress"
                                                                                style="border-radius: 0 !important; display: grid;
                                                                                            grid-template-columns: repeat(12, 1fr);">
                                                                                <div class="progress-bar"
                                                                                    style="                                                                                 width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                                <div class="progress-bar"
                                                                                    style=" border-left: 1px solid #cbcbcb;                                                                                  width: 0%; ">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif




                                                                </div>

                                                            </div>

                                                            <div class="col-md-3 mobile-hidden"
                                                                style="height: 100%; padding: 0">
                                                                <div class="homes-button"
                                                                    style="width: 100%; height: 100px !important">
                                                                    <button class="first-btn payment-plan-button"
                                                                        project-id="283" data-sold="0"
                                                                        order="1" data-block=""
                                                                        data-payment-order="1">
                                                                        Ödeme Detayı
                                                                    </button>








                                                                    <button class="CartBtn second-btn mobileCBtn"
                                                                        data-type="project" data-project="283"
                                                                        style="height: auto !important" data-id="1"
                                                                        data-share="[&quot;Var&quot;]"
                                                                        data-number-share="12">
                                                                        <span class="IconContainer">
                                                                            <img src="http://127.0.0.1:8000/sc.png"
                                                                                alt="">
                                                                        </span>
                                                                        <span class="text">Sepete Ekle</span>
                                                                    </button>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @endif

                            {{-- <p> {!! isset($projectData) && isset($projectData['description']) ? $projectData['description'] : '' !!}
                            </p>
                            <hr>
                            @if (isset($labels))
                                <div class="similar-property featured portfolio p-0 bg-white">

                                    <div class="single homes-content">
                                        @if (count($labels) > 0)
                                            @foreach ($labels as $label => $val)
                                                @if (is_array($val))
                                                    @if (count($val) > 1)
                                                        @if ($label != 'Galeri')
                                                            <h5>
                                                                {{ $label }}</h5>

                                                            <ul class="homes-list clearfix mb-3 checkSquareIcon">
                                                                @foreach ($val as $item)
                                                                    <li><i class="fa fa-check-square"
                                                                            aria-hidden="true"></i><span>{{ $item }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            <div>
                                                <span>Bu ilana ait herhangi bir özellik
                                                    belirtilmemiştir.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif --}}

                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>


<style>
    .container {
        position: relative;

    }

    .watermark {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 400;
        background-image: url("/classified_preview_overlay.png");
        -webkit-background-size: 100%;
        -moz-background-size: 100%;
        background-size: 100%;
    }


    .blog-info.details {
        background: #fff;
        padding: 20px
    }

    .table td {
        display: flex !important;
        justify-content: space-between;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
    integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
        $('.listingDetailsSliderNav').slick({
            slidesToShow: 5,
            slidesToScroll: 5,
            dots: false,
            loop: false,
            autoplay: false,
            arrows: false,
            margin: 0,
            adaptiveHeight: true,
            responsive: [{
                breakpoint: 993,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                    dots: false,
                    arrows: false
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    dots: false,
                    arrows: false
                }
            }]
        });
    });
</script>
