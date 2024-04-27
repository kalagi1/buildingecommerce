@extends('institutional.layouts.master')

@section('content')
    @if($hasTemp)
        <div class="pop-up-v2">
            <div class="pop-back">

            </div>
            <div class="pop-content">
                <div class="pop-content-inner">
                    <h2 class="text-center">Önceden ilan vermeye başlamışsınız. Kaldığınız yerden devam etmek ister misiniz?</h2>
                    <div class="choises">
                        <div class="choise choise-1">
                            Kaldığım Yerden Devam Et
                        </div>
                        <div class="choise choise-2">
                            Yeni İlan Oluştur
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="content">
        <h4 class="mb-2 lh-sm @if (isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
        
Emlak İlanı Ekle    
        </h4>

        <div class="breadcrumb  @if(isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
            <span>Emlak</span>
            @foreach($areaSlugs as $slug)
                <span class="breadcrumb-after-item">{{$slug}}</span>
            @endforeach
        </div>
        <div class="mt-4">
            <div class="progress-area">
                <div class="progress-line step{{ $tempDataFull->step_order }}">
                    <ol>
                        <li
                            @if (isset($tempDataFull) && $tempDataFull->step_order == 1) class="current" @elseif($tempDataFull->step_order > 1) class="done" @endif>
                            <a href="" class="step-counter"><i class="fa fa-star"></i> <span>1</span></a>
                            <a href="">Kategori Seçimi</a>
                        </li>
                        <li
                            @if (isset($tempDataFull) && $tempDataFull->step_order == 2) class="current" @elseif($tempDataFull->step_order > 2) class="done" @endif>
                            <a href="" class="step-counter"><i class="fa fa-star"></i> <span>2</span></a>
                            <a href="">İlan Detayları</a>
                        </li>
                        <li
                            @if (isset($tempDataFull) && $tempDataFull->step_order == 3) class="current" @elseif($tempDataFull->step_order > 3) class="done" @endif>
                            <a href="" class="step-counter"><i class="fa fa-star"></i> <span>3</span></a>
                            <a href="">Doping</a>
                        </li>
                        <li @if (isset($tempDataFull) && $tempDataFull->step_order == 4) class="current" @endif>
                            <a href="" class="step-counter"><i class="fa fa-star"></i> <span>4</span></a>
                            <a href="">Tebrikler</a>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="clear-both"></div>
            <div class="firt-area @if(isset($tempDataFull->step_order) && $tempDataFull->step_order != 1) d-none @endif">
                <div class="row">
                    <div class="area-lists">
                        <div class="area-list active ">
                            <ul>
                                @foreach($housingTypeParent as $parent)
                                <li @if(isset($tempData->step1_slug) && $tempData->step1_slug == $parent->slug) class="selected" @endif slug="{{$parent->slug}}">{{$parent->title}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && $tempData->step1_slug) active @endif">
                            <ul>
                                @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && $tempData->step1_slug)
                                    @foreach($secondAreaList as $secondAreaItem)
                                        <li @if(isset($tempData->step2_slug) && $tempData->step2_slug && $tempData->step2_slug == $secondAreaItem->slug) class="selected" @endif slug="{{$secondAreaItem->slug}}">{{$secondAreaItem->title}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempDataFull->data) && isset($tempData->step2_slug) && $tempData->step2_slug) active @endif">
                            <ul>
                                @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
                                    @foreach($housingTypes as $housingType)
                                        <li @if(isset($tempData->step3_slug) && $tempData->step3_slug && $tempData->step3_slug == $housingType->slug) class="selected" @endif slug="{{$housingType->slug}}">{{$housingType->title}}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="area-list @if(isset($tempDataFull->data) && isset($tempData->step3_slug) && $tempData->step3_slug) active @endif">
                            <div class="finish-category-select">
                                <div class="finish-icon-area">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="finish-text">
                                    <p>Kategori Seçimi Tamanlanmıştır</p>
                                </div>
                                <div class="finish-button-first">
                                    <button class="btn btn-info">
                                        Devam
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="second-area @if ($tempDataFull->step_order != 2) d-none @endif">
                <div class="row">
                    <div class="thumbnail-second">
                        <span class="section-title">Kategori</span>
                        <div class="card px-5 py-2 breadcrumb breadcrumb-v2" style="display: flex;flex-direction:row;">
                            <div class="icon"><i class="fa fa-house"></i></div> Emlak
                            @foreach($areaSlugs as $slug)
                                <span class="breadcrumb-after-item">{{$slug}}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-area mt-4">
                        <span class="section-title">İlan Detayları</span>

                        <div class="card py-2 px-5">
                            <div class="form-group">
                                <label for="">İlan Başlığı <span class="required">*</span></label>
                                <input type="text" value="{{ isset($tempData->name) ? $tempData->name : '' }}"
                                    onchange="changeData(this.value,'name')" name="name" class="form-control">
                            </div>
                            <div class="form-group description-field">
                                <label for="">İlan Açıklaması <span class="required">*</span></label>
                                <textarea name="description" id="editor" cols="30" rows="5" onkeyup="changeData(this.value,'description')"
                                    class="form-control">{{ isset($tempData->description) ? $tempData->description : '' }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab-content " id="pricingTabContent" role="tabpanel">
                                        <div id="renderForm"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="address">
                            <span class="section-title">Adres Bilgileri</span>
                            <div class="card">
                                <div class="row px-5 py-4">
                                    <div class="col-md-4">
                                        <label for="">İl <span class="required">*</span></label>
                                        <select onchange="changeData(this.value,'city_id')" name="city_id" id="cities"
                                            class="form-control">
                                            <option value="">İl Seç</option>
                                            @foreach ($cities as $city)
                                                <option
                                                    {{ isset($tempData->city_id) && $tempData->city_id == $city['id'] ? 'selected' : '' }}
                                                    value="{{ $city['id'] }}">{{ $city['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">İlçe <span class="required">*</span></label>
                                        <select onchange="changeData(this.value,'county_id')" name="county_id"
                                            id="counties" class="form-control">
                                            <option value="">İlçe Seç</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Mahalle <span class="required">*</span></label>
                                        <select onchange="changeData(this.value,'neighbourhood_id')"
                                            name="neighbourhood_id" id="neighbourhood" class="form-control">
                                            <option value="">Mahalle Seç</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <input name="location" class="form-control" id="location" readonly type="hidden"
                                        value="@if (isset($tempData->location)) {{ $tempData->location }}@else 32.9231576,37.3927733 @endif" />
                                    <div id="mapContainer" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                        <span class="section-title mt-4">Kapak Fotoğrafı</span>
                        <div class="cover-photo-full card py-2 px-5">
                            <input type="file" name="cover-image" accept="image/*" class="cover_image d-none">
                            <div class="upload-container col-md-3 cover-photo-area" ondrop="handleDrop(event)" ondragover="allowDrop(event)">
                                <div class="border-container">
                                  <div class="icons fa-4x">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                              </div>
                            <div class="cover-photo">
                                @if(isset($tempData->cover_image) && $tempData->cover_image)
                                    <div class="project_imagex">
                                        <img src="{{URL::to('/')}}/project_images/{{$tempData->cover_image}}" alt="">
                                    </div>
                                @endif
                            </div>
                        </div>
                        <span class="section-title mt-4">İlan Galerisi</span>
                        <div class="photo card py-2 px-5">
                            <input type="file" multiple name="project-images" accept="image/*" class="project_image d-none">
                            <div class="upload-container col-md-3 photo-area"  ondrop="handleDrop2(event)" ondragover="allowDrop2(event)">
                                <div class="border-container">
                                  <div class="icons fa-4x">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-2 up-4"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Fotoğraf Ekle <span>veya sürükle bırak</span></p>
                                </div>
                            </div>
                            <div class="photos">
                                @if(isset($tempData->images) && $tempData->images)
                                    @foreach($tempData->images as $image)
                                        <div class="project_imagex"  order="{{$image}}">
                                            <img src="{{URL::to('/')}}/project_images/{{$image}}" alt="">
                                            <div class="image-buttons">
                                                <i class="fa fa-trash"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <span class="section-title mt-4">Ruhsat Belgesi / Tapu Belgesi</span>
                        <div class="cover-photo-full card py-2 px-5">
                            <input type="file" name="cover-image" class="document d-none" accept="application/pdf,application/vnd.ms-excel">
                            <div class="upload-container col-md-3 cover-document-area"  ondrop="handleDrop3(event)" ondragover="allowDrop3(event)">
                                <div class="border-container">
                                  <div class="icons fa-4x mb-4">
                                    <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
                                    <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
                                    <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
                                  </div>
                                  <!--<input type="file" id="file-upload">-->
                                  <p>Bilgisayardan Dosya Ekle <span>veya sürükle bırak</span></p>
                                </div>
                            </div>
                            <div class="cover-document">
                                @if(isset($tempData->document) && $tempData->document)
                                    <div class="has_file">
                                        <span class="d-block">Dosya Eklediniz</span>
                                        <a class="btn btn-info" href="{{URL::to('/')}}/housing_documents/{{$tempData->document}}" download="">Mevcut Dosyayı İndir</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="second-area-finish">
                            <div class="finish-tick ">
                                <input type="checkbox" value="1" class="rules_confirm">
                                <span class="rulesOpen">İlan verme kurallarını</span>
                                <span>okudum, kabul ediyorum</span>
                            </div>
                            <div class="finish-buttonx" style="float:right;margin:0;">
                                <button class="btn btn-info">
                                    Devam
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="third-area @if ($tempDataFull->step_order != 3) d-none @endif">
                
                <div class="row" style="align-items: flex-end;">
                    <div class="col-md-4">
                        <div class="doping-square @if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured) && $tempData->featured) selected @endif" data-id="1">
                            <div class="row" style="align-items: center">
                                <div class="col-md-12">
                                    <span class="doping-is-selected">@if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured) && $tempData->featured) Seçildi @else Seçilmedi @endif </span>
                                    <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="">
                                    <h4 class="mt-3">Öne Çıkarılanlar Vitrini</h4>
                                    <span>İlanınız anasayfamızda önce çıkan emlak ilanları sekmesinde yer alsın.</span>
                                    <select name="" id="" class="form-control mt-3">
                                        <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured_data_day) && $tempData->featured_data_day == "7") selected @endif value="7">1 Hafta (2259 TL)</option>
                                        <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->featured_data_day) && $tempData->featured_data_day == "14") selected @endif value="14">2 Hafta (4500 TL)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="doping-square @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row) && $tempData->top_row) selected @endif" data-id="2">
                            <div class="row" style="align-items: center">
                                <div class="col-md-12">
                                    <span class="doping-is-selected">@if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row) && $tempData->top_row) Seçildi @else Seçilmedi @endif</span>
                                    <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="">
                                    <h4 class="mt-3">Üst Sıradayım</h4>
                                    <span>İlanınız anasayfamızda önce çıkan emlak ilanları sekmesinde yer alsın.</span>
                                    <select name="" id="" class="form-control mt-3">
                                        <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row_data_day) && $tempData->top_row_data_day == "7") selected @endif value="7">1 Hafta (2000 TL)</option>
                                        <option @if(isset($tempDataFull) && isset($tempData) && isset($tempData->top_row_data_day) && $tempData->top_row_data_day == "14") selected @endif value="14">2 Hafta (3500 TL)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="without-dopingxx mt-4 mb-5">
                        <button class="without-doping btn btn-info">Devam</button>
                    </div>
                </div>
                <div class="category-select">
                </div>
            </div>
            <div class="fourth-area d-none">
                <div class="row" style="justify-content:center;">
                    <div class="col-md-5">
                        <div class="finish-area">
                            <div class="icon"><i class="fa fa-thumbs-up"></i></div>
                            <div class="text">Başarıyla ilan eklediniz</div>
                            <div class="text"><a href="{{ route('institutional.housing.list') }}"
                                    class="btn btn-info">Mağazama Git</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rulesOpenModal" tabindex="-1" role="dialog"
    aria-labelledby="finalConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalConfirmationModalLabel">İlan Verme Kuralları</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <ol>
                    <li> İlan yayıncısı EMLAKSEPETTE’de ilanlarını yayınlayarak “İlan Yayınlama Kuralları”nı kabul etmiş sayılır. Bu sebeple ilan yayınlayan her kişi ve kurum kurallara riayet etme mecburiyetindedir.</li>
                    <li> İlan yayıncıları ilanın içeriğiyle ilgili bilgilerin doğruluğundan sorumludur. İlan bilgileri içerisindeki gerçek dışı fiyat, metrekare, açıklama, kat sayısı gibi parametreler sonucunda ilan, ilan sahibinde danışılmaksızın sistemden kaldırılabilir.</li>
                    <li> İlan içerisinde yer alan fotoğrafların emlak ile ilişkili olması, ilanı yayınlayan kurumun ya da kişinin logo, tanıtım görseli vb.. olmaması gerekmektedir. Sistemde bulunan diğer ilanlardan ayrışmak maksadıyla ve haksız rekabet yaratmak amacıyla ilan resimlerinin üzerine herhangi bir yazı, ikon, şerit, çerçeve yerleştirilmesi fotoğrafın yayından kaldırılmasına sebep olabilir.</li>
                    <li> İlan sahibi aynı gayrimenkulle ilgili sadece bir adet ilan yayınlayabilir. Aynı emlak ile ilgili girilecek çoklu kayıtlar mükerrer ilan sayılacaktır. Mükerrer ilanlar haksız rekabete yol açtığından ötürü sistemden ilan sahibine duyurmaksızın tamamen kaldırılabilir.</li>
                    <li> İlan başlığı içerisinde yalnızca ilanda söz konusu olan gayrimenkule ait bilgiler verilebilir. İlan başlığı içerisinde iletişim bilgisi gibi haksız rekabete yol açabilecek bilgilerin yer verilmesi ilanın yayından kaldırılmasına sebep olabilir.</li>
                    <li> İlan başlığı içerisinde Türkçe karakterler, Türk alfabesinde bulunmayan X, W, Q harfleri, rakamlar, nokta(.), virgül(,), ünlem(!) noktalama işaretleri kullanılabilir. Bu karakterlerin dışında kullanılacak alfanumerik olmayan, rekabete gölge düşürecek hiçbir karakterin ilanlarda yer almasına izin verilmeyecektir.</li>
                    <li> İlan sahibi tarafından satılmış ya da kiralanmış gayrimenkullere ait ilanlar, ilan sahibi tarafından arşivlenmelidir. EMLAKSEPETTE sistemindeki operasyonu tamamlanmış ilanları belirli periyotlarla sistem haricine çıkarma hakkını saklı tutar. Bu işlem sonrasında doğacak yedekleme problemlerinden EMLAKSEPETTE sorumlu değildir.</li>
                    <li> İlan bilgilerinin doluluğu ve doğruluğu, fotoğrafların kalitesi ve geçmiş hareketler göz önünde bulundurularak ilan sahiplerinin ilanları değerlendirilebilir. İlan yayınlama kurallarını sıklıkla ihlal eden kullanıcıların sözleşmesini tek taraflı olarak fesh etme hakkını EMLAKSEPETTE saklı tutar. Aynı şekilde ilan bilgilerini daimi olarak doğru ve hatasız giren kullanıcılar, haksız rekabete yol açmayacak şekilde sistem algoritması tarafından ödüllendirilerek ilanların öne çıkması sağlanabilir.</li>
                    <li> İlan içerisinde yer alan ifadelerin cinsiyet, ırk, renk, dil, din, inanç, mezhep, felsefi ve siyasi görüş, etnik köken, servet, doğum, medeni hâl, sağlık durumu, engellilik ve yaş temellerine dayalı ayrımcılık niteliği taşımaması yasal bir zorunluluktur. Bu tür ifadeler kullanılması hukuka aykırı olup, Türkiye İnsan Hakları ve Eşitlik Kurumu (TİHEK) tarafından idari para cezası verilmesine sebep olabilir. Ayrıca, İlanda belirtilen ifadelerle ayrımcılığa yol açabilecek bilgilere yer verilmesi ilgili ifadelerin ve/veya ilanın yayından kaldırılması sebebidir.</li>
                    <li> İlan yayınlama kurallarına riayet etmeyen kullanıcıların ilanlarındaki bilgilerinin bir kısmı ya da tamamının yayından kaldırılması hakkını EMLAKSEPETTE saklı tutar.</li>
                    <li> Bireysel ve Kurumsal Hesap Sahibi, Portal üzerinden ilan verme, ilan düzenleme ve ilanı yeniden yayına alma işlemlerinden önce yasal mevzuat gereği sistem üzerinden kimliklerini doğrulamalıdır. Bireysel ve Kurumsal Hesap Sahibi, doğrulama işlemi yapmadıkları takdirde ilgili mevzuat uyarınca ilan veremeyeceklerini kabul eder. </li>
                    <li> İlan başlığında ve ilan açıklama bölümünde sadece gayrimenkul hakkındaki bilgiler yer almalıdır.</li>
                    <li> İlan başlığında ve ilan açıklama bölümlerde reklam içerikli yazı yazılmaması, link ve ürüne ait fotoğrafların eklenmemesi gerekmektedir.</li>
                    <li> Yayınlanmak istenen ilanlarda kullanılan fotoğraflar, videolar ve 3 Boyutlu Tur görüntüsü, satılan/kiralanan gayrimenkule ait olmalıdır. Yayınlanan içerikler, fotoğraf, video veya link olarak ilana eklenen 3 Boyutlu Tur görüntüler hakkında EMLAKSEPETTE'nin herhangi bir sorumluluğu bulunmamaktadır.</li>
                    <li> İlan girişlerinde belirtilen kriterlerde (metrekare, oda sayısı, bulunduğu kat, fiyat v.b.) doğru bilgiler yer almalıdır.</li>
                    <li> Eklenen fotoğrafların, videoların, 3 Boyutlu Tur görüntülerinin içeriğinde firma logoları, telefon numarası veya farklı web sitelerinin link, logo ya da isimleri yer almamalıdır. Seçili vitrin resmi olarak işaretlenen görsellerde; firma logoları, telefon numarası, web sitelerinin linki, renkli arka plan, renkli çerçeve, metin içerikleri,firma isimleri, photoshop ve benzeri uygulamalarla eklentiler yer almamalıdır.</li>
                    <li> Sistem içerisindeki farklı bir kullanıcının fotoğrafı / fotoğrafları kullanılmamalıdır.</li>
                    <li> Bir gayrimenkulü satmak için ayrı, kiralamak için ayrı ilan verilmelidir. Aynı ilanda hem satılık hem kiralık detayları bulunamaz.</li>
                    <li> Girilen bir ilanın aynısı, ilk girilen ilan silinerek sisteme yeniden girilemez. Bir ilanın silinip sisteme tekrar yeni baştan girilmesi ve benzeri nitelikteki faaliyetleri gerçekleştiren hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal edilebilir.</li>
                    <li> Aynı sitede veya blokta bulunan ve aynı özellikleri taşıyan gayrimenkuller için ayrı ilan girişi yapılmaması, tek bir ilan verilmesi ve bu ilanın açıklamasında aynı konumda farklı dairelerin de olduğunun belirtilmesi gerekmektedir. Aynı özellikte ikinci ilan girişi mükerrer (aynı kayıt) sayılmaktadır.</li>
                    <li> Her bir ilan için farklı resimler kullanılmalıdır, aynı konumda dahi olsa aynı resim ikinci bir ilanda kullanılmamalıdır.</li>
                    <li> Emlak ilan girişleri mutlaka mal sahibi tarafından veya mal sahibinin onayı alınarak yapılmalıdır. Bu sorumluluk ilan verene aittir. Mal sahibinin itirazı doğrultusunda hesap sahiplerinin bu ilanları silinebilir, hesapları geçici olarak durdurulabilir veya iptal edilebilir.</li>
                    <li> Satılık veya kiralık gayrimenkuller için temsili fiyat verilmemelidir.</li>
                    <li> İlan açıklama bölümlerinde web sayfası, mail adresi ve firma iletişim bilgilerine yer verilmemelidir. Telefon numarası ve kullanıcı adı sadece “Kullanıcı bilgileri” bölümünde yayınlanmalıdır. Mağaza kullanıcıları mağazaları için tanıtım sayfası hazırlayarak iletişim ve adres bilgilerini bu alanda yayınlayabilirler ancak web sayfası ve mail adreslerini belirtmemeleri gerekir</li>
                    <li> Satılan ya da kiralanan ürünler Satıldı / Kiralandı olarak tekrar yayına verilemez. Satış işleminin devam ettiği izlenimi yaratan ya da tüketiciyi aldatma ve yanıltma ihtimali yaratabilecek “opsiyonlanmıştır', “kaporası alınmıştır”, "satılmıştır", "ilginiz için teşekkürler" gibi ya da bunlara benzer anlamda ibareler içeren ilanlar yayına alınmaz, yayında olan ilanlar yayından kaldırılır.</li>
                    <li> İlan verme aşamasında, ilana ait belirlenmiş bazı kriterler için girilen bilgiler, ilan veren tarafından sonradan değiştirilemez, ilan veren bu konuda itirazda bulunmayacağını peşinen kabul etmektedir. EMLAKSEPETTE hangi kriterlere ait bilgilerin değiştirilemeyeceğini belirleme, zaman içinde belirlediği kriterlerde değişiklik yapma ve değişiklik yapma tarihi itibariyle belirlediği kriterleri tüm ilanlara uygulama hakkını saklı tutmaktadır.</li>
                    <li> Günlük Kiralık İlan yayınlayanlar; 22/11/2016 tarihli Olağanüstü Hal Kapsamında Bazı Düzenlemeler Yapılması Hakkında Kanun Hükmünde Kararname ile getirilen yeni düzenlemelere, yasal mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal yükümlülüklerini yerine getirmeden günlük kiralık ilan yayınlayanlar hakkında uygulanacak cezalardan münhasıran Günlük Kiralık İlan Veren sorumlu olacaktır.</li>
                    <li> Turizm Amaçlı Kiralama amaçlı kiralık ilan yayınlayanlar; “7464 sayılı “Konutların Turizm Amaçlı Kiralama Amaçlı Kiralanmasına ve Bazı Kanunlarda Değişiklik Yapılmasına Dair Kanun” ile getirilen yeni düzenlemelere, yasal mevzuata ve Portal'daki İlan Yayınlama Kurallarına uygun hareket etmekle yükümlüdür. Yasal yükümlülüklerini yerine getirmeden turizm amaçlı kiralık ilan yayınlayanlar hakkında uygulanacak cezalardan münhasıran İlan Veren sorumlu olacaktır.</li>
                    <li> Konut> Kiralık kategorisinde sadece aylık kiralık ilanlar verilebilir. Günlük, haftalık vb. kiralık ilanların Günlük Kiralık kategorisinden verilmesi gerekmektedir.</li>
                    <li> Günlük kiralık dairelerde, fiyat kriterine günlük kiralama bedeli girilmelidir.</li>
                    <li> İlanın işyeri ya da konut olarak değerlendirilmesinin kararı ilan verenin sorumluluğundadır. Seçilmiş kategori doğru olarak kabul edilir, ilan verme kurallarına aykırı bir durum yer almıyor ise ilan yayına alınır.</li>
                    <li> Her farklı taşınmaz için ayrı ilan verilmelidir. Farklı konumdaki, taşınmazlar için toplu satış yapılamamaktadır.</li>
                    <li> Turistik Tesis kategorisinde sadece turistik bir tesisin tamamı kiralanabilir ya da tamamının satışı yapılabilir.</li>
                    <li> 13 Eylül 2018 tarihli "Türk Parasının Kıymetini Koruma hakkında 32 sayılı Kararda Değişiklik Yapılmasına Dair Karar"da, 6 Ekim 2018 tarihli “Türk Parası Kıymetini Koruma Hakkında 32 Sayılı Karara İlişkin Tebliğ”de ve 16 Kasım 2018 tarihli ve 30597 sayılı Türk Parası Kıymetini Koruma Hakkında 32 Sayılı Karara İlişkin Tebliğ'de Değişiklik Yapılmasına Dair Tebliğ'de belirtilen sözleşme tiplerine dair kategorilerdeki ilanların fiyat bilgilerinin Türk Lirası olarak girilmesi gerekmektedir.</li>
                    <li> Metaverse, OVR, sanal arazi, sanal dünya üzerinden arazi ve arsa satışları üzerinden arazi ve arsa satışlarına izin verilmez.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.min.js"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/moment.min.js"
        integrity="sha512-CryKbMe7sjSCDPl18jtJI5DR5jtkUWxPXWaLCst6QjH8wxDexfRJic2WRmRXmstr2Y8SxDDWuBO6CQC6IE4KTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ URL::to('/') }}/adminassets/assets/js/jquery.daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"
        integrity="sha512-zlWWyZq71UMApAjih4WkaRpikgY9Bz1oXIW5G0fED4vk14JjGlQ1UmkGM392jEULP8jbNMiwLWdM8Z87Hu88Fw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-ip8tV3D9tyRNS8RMUwxU8n7mCJ9WCl0&callback=initMap" async defer></script>
        

    <script>

$('.rulesOpen').click(function(){
                $('#rulesOpenModal').addClass('show')
                $('#rulesOpenModal').addClass('d-block')
            })

            $('#rulesOpenModal').click(function(){
                $(this).removeClass('show')
                $(this).removeClass('d-block')
            })

            $('#rulesOpenModal .close').click(function(){
                $(this).removeClass('show')
                $(this).removeClass('d-block')
            })

            $('#rulesOpenModal .modal-dialog').click(function(e){
                if(!$(event.target).hasClass('close')){
                    e.stopPropagation();
                }
            })


        var map;
        var markers = [];
        function initMap(cityName,zoomLevel) {
            // Harita oluştur
            map = new google.maps.Map(document.getElementById('mapContainer'), {
                zoom: 10,  // Başlangıç zoom seviyesi
                center: {lat: 41.0082, lng: 28.9784}  // Başlangıç merkez koordinatları (İstanbul örneği)
            });


            google.maps.event.addListener(map, 'click', function(event) {
                clearMarkers(); // Tüm işaretçileri temizleyin
                placeMarker(event.latLng); // Yeni işaretçiyi ekleyin
            });

            if (cityName) {
                // Google Haritalar Geocoding API'yi kullanarak şehir adını koordinatlara dönüştür
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({ address: cityName }, function(results, status) {
                if (status === 'OK') {
                    // Başarılı ise haritayı zoomla
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(zoomLevel);  // İstediğiniz zoom seviyesini ayarlayabilirsiniz
                } else {
                    alert('Şehir bulunamadı: ' + status);
                }
                });
            }
        }

        
        window.initMap = initMap;

        function placeMarker(location) {
            // İşaretçiyi oluşturun
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            // Bilgi penceresi oluşturun (isteğe bağlı)
            var infowindow = new google.maps.InfoWindow({
                content: 'Koordinatlar: ' + location.lat() + ', ' + location.lng()
            });

            
            $('#mapContainer').parent('div').find('.alert-danger').remove();

            changeData(location.lat()+','+location.lng(),'location');

            // İşaretçiye tıklandığında bilgi penceresini gösterin
            marker.addListener('click', function() {
                infowindow.open(map, marker);
            });

            markers.push(marker); // İşaretçiyi dizide saklayın
        }

        
        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }

        
        @if(isset($tempData->location) && $tempData->location)
            @php 
                $location = explode(',',$tempData->location);
            @endphp
            setTimeout(() => {
                var marker = new google.maps.Marker({
                    position: {lat: {{$location[0]}}, lng: {{$location[1]}}},
                    map: map,
                });

                markers.push(marker); // İşaretçiyi dizide saklayın
            }, 2000);
        @endif

        @if(!isset($tempDataFull) || !isset($tempData) || !isset($tempData->top_row))
            changeData(0,"top_row");
        @endif
        @if(!isset($tempDataFull) || !isset($tempData) || !isset($tempData->featured))
            changeData(0,"featured");
        @endif
        $('.doping-square').click(function(){
            if($(this).hasClass('selected')){
                if($(this).attr('data-id') == "1"){
                    changeData(0,"featured");
                }else{
                    changeData(0,"top_row");
                }
                $(this).removeClass('selected')
                $(this).find('.doping-is-selected').html('Seçilmedi')
            }else{
                if($(this).attr('data-id') == "1"){
                    changeData(1,"featured");
                    changeData($(this).find('select').val(),'featured_data_day')
                }else{
                    changeData(1,"top_row");
                    changeData($(this).find('select').val(),'top_row_data_day')
                }
                $(this).addClass('selected')
                $(this).find('.doping-is-selected').html('Seçildi')
            }
        })
        $('.doping-square select').click(function(e){
            e.stopPropagation();
        })
        $('.doping-square select').change(function(e) {
            var dataId = $(this).closest('.doping-square').attr('data-id')
            if(dataId == "1"){
                changeData(1,"featured");
                changeData($(this).val(),'featured_data_day')
            }else{
                changeData(1,"top_row");
                changeData($(this).val(),'top_row_data_day')
            }
        })

        @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
            @if($tempData->step2_slug == "kiralik")
                var isRent = 1;
            @else
                var isRent = 0;
            @endif
        @else
            var isRent = 0;
        @endif

        @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
            @if($tempData->step2_slug == "gunluk-kiralik")
                var isDailyRent = 1;
            @else
                var isDailyRent = 0;
            @endif
        @else
            var isDailyRent = 0;
        @endif

        @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
            @if($tempData->step2_slug == "satilik")
                var isSale = 1;
            @else
                var isSale = 0;
            @endif
        @else
            var isSale = 0;
        @endif

        var nextTemp = false;
        var descriptionText =
            @if (isset($tempData) && isset($tempData->description))
                "evet var"
            @else
                ""
            @endif ;
        var selectedid =
            @if (isset($tempData) && isset($tempData->housing_type_id))
                {{ $tempData->housing_type_id }}
            @else
                0
            @endif ;

        $('.choise-2').click(function(){
            $.ajax({
                method: "POST",
                url: "{{route('institutional.delete.temp.create')}}",
                data : {
                    item_type : 2,
                    _token : csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if(response.status){
                        window.location.href = window.location.href
                    }
                    
                }
            })
        })

        $('.choise-1').click(function(){
            $('.pop-up-v2').addClass('d-none')
        })

        $('.project_imagex .image-buttons').click(function(){
            var thisx = $(this);
            $.ajax({
                url: '{{route("institutional.delete.image.order.temp.update")}}',
                type: 'POST',
                data: { 
                    image: $(this).closest('.project_imagex').attr('order') ,
                    item_type : 2,
                    _token : csrfToken
                },
                success: function(response) {
                    thisx.closest('.project_imagex').remove()
                },
                error: function(xhr, status, error) {
                    console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                }
            });
        })

        $('.photos').sortable({
            revert: true,
            update: function(event, ui) {
                var ids = [];
                for(var i = 0; i < $('.photos .project_imagex').length; i++){
                    ids.push($('.photos .project_imagex').eq(i).attr('order'));
                }
                console.log(ids);
                // Sıralama değiştiğinde bir Ajax POST isteği gönder
                $.ajax({
                    url: '{{route("institutional.update.image.order.temp.update")}}',
                    type: 'POST',
                    data: { 
                        images: ids ,
                        item_type : 2,
                        _token : csrfToken
                    },
                    success: function(response) {
                        console.log("Sıralama güncellendi.");
                    },
                    error: function(xhr, status, error) {
                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                    }
                });
            }
        });

        $('.project_imagex').draggable({
            connectToSortable: ".photos",
        });

        $('input[name="name"]').keyup(function() {
            console.log("asd");
            if ($(this).val() != "") {
                $(this).removeClass('error-border');
            }
        })

        changeData(1, 'house_count');


        @if(isset($tempData->city_id))
            @php 
                $cityJs = DB::table('cities')->where('id',$tempData->city_id)->first();
            @endphp

            cityName = "{{$cityJs->title}}";
            @if(isset($tempData->county_id))
                @php 
                    $countyJs = DB::table('districts')->where('ilce_key',$tempData->county_id)->first();
                @endphp

                countyName = "{{$countyJs->ilce_title}}";
                @if(isset($tempData->neighbourhood_id))
                    @php 
                        $countyJs = DB::table('neighborhoods')->where('mahalle_id',$tempData->neighbourhood_id)->first();
                    @endphp

                    neighbourhoodName = "{{$countyJs->mahalle_title}}";
                    
                    setTimeout(() => {
                        initMap(cityName+','+countyName+','+neighbourhoodName,13);
                    }, 1000);
                @else 
                    setTimeout(() => {
                    initMap(cityName+','+countyName,13);
                    }, 1000);
                @endif
            @else
                setTimeout(() => {
                    initMap(cityName,10);
                }, 1000);
            @endif
        @endif

        $('#cities').change(function(){
            var selectedCity = $(this).val(); // Seçilen şehir değerini al
            cityName = $('#cities option[value="'+selectedCity+'"]').html()
            initMap(cityName,10)
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })

        $('#counties').change(function(){
            var selectedCounty = $(this).val(); // Seçilen şehir değerini al
            countyName = $('#counties option[value="'+selectedCounty+'"]').html()
            initMap(cityName+','+countyName,13);
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })

        $('#neighbourhood').change(function(){
            
            neighbourhoodName = $('#neighbourhood option[value="'+$(this).val()+'"]').html()
            initMap(cityName+','+countyName+','+neighbourhoodName,15)
            if($(this).val() != ""){
                $(this).removeClass('error-border');
            }
        })

        $('.progress-line li').click(function(e) {
            e.preventDefault();
            var currentIndex = $('.progress-line li.current').index();

            var clickIndex = $(this).index();
            if (clickIndex == 0) {
                toFirstArea();
            } else if (clickIndex == 1) {
                toSecondArea();
            }
            if (clickIndex == 2) {
                toThirdArea();
            }

        })

        function toSecondArea() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.change.step.order') }}",
                data: {
                    order: 2,
                    item_type: 2,
                    _token: csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        $('.firt-area').addClass('d-none');
                        $('.second-area').addClass('d-none');
                        $('.third-area').addClass('d-none');
                        $('.progress-line').removeClass('step1')
                        $('.progress-line').removeClass('step2')
                        $('.progress-line').removeClass('step3')
                        $('.second-area').removeClass('d-none');
                        $('.progress-line').addClass('step2')
                        $('.progress-line li').eq(0).removeClass('current').addClass('done')
                        $('.progress-line li').eq(1).addClass('current')
                        $('.progress-line li').eq(2).removeClass('current').removeClass('done')
                    }

                }
            })
        }

        function toThirdArea() {
            $('.finish-button').trigger('click');

            if (nextTemp) {
                $.ajax({
                    method: "POST",
                    url: "{{ route('institutional.change.step.order') }}",
                    data: {
                        order: 3,
                        item_type: 2,
                        _token: csrfToken
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        if (response.status) {
                            $('.firt-area').addClass('d-none');
                            $('.second-area').addClass('d-none');
                            $('.third-area').addClass('d-none');
                            $('.progress-line').removeClass('step1')
                            $('.progress-line').removeClass('step2')
                            $('.progress-line').removeClass('step3')
                            $('.third-area').removeClass('d-none');
                            $('.progress-line').addClass('step3')
                            $('.progress-line li').eq(0).removeClass('current').addClass('done')
                            $('.progress-line li').eq(1).removeClass('current').addClass('done')
                            $('.progress-line li').eq(2).addClass('current')
                        }

                    }
                })

            }

        }

        function toFirstArea() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.change.step.order') }}",
                data: {
                    order: 1,
                    item_type: 2,
                    _token: csrfToken
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        $('.second-area').addClass('d-none');
                        $('.third-area').addClass('d-none');
                        $('.progress-line').removeClass('step1')
                        $('.progress-line').removeClass('step2')
                        $('.progress-line').removeClass('step3')
                        $('.firt-area').removeClass('d-none');
                        $('.progress-line').addClass('step1')
                        $('.progress-line li').eq(0).addClass('current').removeClass('done')
                        $('.progress-line li').eq(1).removeClass('current').removeClass('done')
                        $('.progress-line li').eq(2).removeClass('current').removeClass('donı')
                    }

                }
            })
        }


        $('.finish-button-first').click(function() {
            toSecondArea();
        });

        $('.doping_statuses').change(function() {
            if ($(this).val() != "") {
                $('.doping_statuses').removeClass('error-border')
            }
        })

        $('.doping_order').change(function() {
            if ($(this).val() != "") {
                $('.doping_order').removeClass('error-border')
            }
        })

        $('.list-dates').click(function() {
            if ($('.doping_statuses').val() == "") {
                $('.doping_statuses').addClass('error-border')
            }

            if ($('.doping_order').val() == "") {
                $('.doping_order').addClass('error-border')
            }

            changeData($('.doping_statuses').val(), "doping_statuses");
            changeData($('.doping_order').val(), "doping_order");
            $.ajax({
                method: "GET",
                url: "{{ URL::to('/') }}/institutional/get_busy_housing_statuses/" + $('.doping_statuses')
                    .val(),
                data: {
                    order: $('.doping_order').val()
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('.daily-price').html(response.price.price + ' ₺')
                    $('.total-price').html('-')
                    $('.date-range').removeClass('d-none');
                    $('#date-range2').dateRangePicker({
                        showShortcuts: false,
                        beforeShowDay: function(t) {
                            const now = new Date();
                            var valid = true;
                            var birGun = 24 * 60 * 60 * 1000;
                            for (var i = 0; i < response.busy_dates.length; i++) {
                                const startTime = new Date(response.busy_dates[i]
                                    .start_date);
                                const endTime = new Date(response.busy_dates[i].end_date);
                                if (t.getTime() < now.getTime() || t.getTime() < (endTime
                                        .getTime() + birGun) && t.getTime() > startTime
                                    .getTime()) {
                                    valid = false;
                                }
                            }

                            if (t.getTime() < now.getTime()) {
                                valid = false;
                            }
                            var _class = '';
                            var _tooltip = valid ? '' : 'Bu tarihler dolu';
                            return [valid, _class, _tooltip];
                        }
                    }).on('datepicker-change', function(event, obj) {
                        /* This event will be triggered when second date is selected */
                        var startTime = new Date(obj.date1);
                        var endTime = new Date(obj.date2);
                        var endTimeFull = endTime.getDate() + '-' + (endTime.getMonth() + 1) +
                            '-' + endTime.getFullYear();
                        var startTimeFull = startTime.getDate() + '-' + (startTime.getMonth() +
                            1) + '-' + startTime.getFullYear();
                        var dateDiff = datediff(startTime.getTime(), endTime.getTime()) + 1;
                        $('.total-price').html((response.price.price * dateDiff) + " ₺")
                        changeData(startTimeFull, "doping_start_date")
                        changeData(endTimeFull, "doping_end_date")
                        changeData(dateDiff, "doping_date_count")
                    })

                }
            })
        })

        @if (isset($tempData->doping_statuses) && isset($tempData->doping_order))
            $.ajax({
                method: "GET",
                url: "{{ URL::to('/') }}/institutional/get_busy_housing_statuses/{{ $tempData->doping_statuses }}",
                data: {
                    order: {{ $tempData->doping_order }}
                },
                success: function(response) {
                    response = JSON.parse(response);
                    $('.daily-price').html(response.price.price + ' ₺')
                    $('.date-range').removeClass('d-none');
                    $('#date-range2').dateRangePicker({
                        showShortcuts: false,
                        beforeShowDay: function(t) {
                            const now = new Date();
                            var valid = true;
                            var birGun = 24 * 60 * 60 * 1000;
                            for (var i = 0; i < response.busy_dates.length; i++) {
                                const startTime = new Date(response.busy_dates[i].start_date);
                                const endTime = new Date(response.busy_dates[i].end_date);
                                if (t.getTime() < now.getTime() || t.getTime() < (endTime
                                        .getTime() + birGun) && t.getTime() > startTime.getTime()) {
                                    valid = false;
                                }
                            }

                            if (t.getTime() < now.getTime()) {
                                valid = false;
                            }
                            var _class = '';
                            var _tooltip = valid ? '' : 'Bu tarihler dolu';
                            return [valid, _class, _tooltip];
                        }
                    }).on('datepicker-change', function(event, obj) {
                        /* This event will be triggered when second date is selected */
                        var startTime = new Date(obj.date1);
                        var endTime = new Date(obj.date2);
                        var endTimeFull = endTime.getDate() + '-' + (endTime.getMonth() + 1) + '-' +
                            endTime.getFullYear();
                        var startTimeFull = startTime.getDate() + '-' + (startTime.getMonth() + 1) +
                            '-' + startTime.getFullYear();
                        var dateDiff = datediff(startTime.getTime(), endTime.getTime()) + 1;
                        $('.total-price').html((response.price.price * dateDiff) + " ₺")
                        changeData(startTimeFull, "doping_start_date")
                        changeData(endTimeFull, "doping_end_date")
                        changeData(dateDiff, "doping_date_count")
                    })
                }
            })

            function datediff(first, second) {
                return Math.round((second - first) / (1000 * 60 * 60 * 24));
            }
        @endif

        var csrfToken = "{{ csrf_token() }}";
        $('.finish-step-3').click(function() {
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.project.end.temp.order') }}",
                data: {
                    _token: csrfToken,
                    without_doping: 0
                },
                success: function(response) {
                    response = JSON.parse(response);

                    if (response.status) {
                        $('.third-area').addClass('d-none');
                        $('.fourth-area').removeClass('d-none')
                    }
                }
            })
        })

        $('.without-doping').click(function() {
            console.log("asd");
            $.ajax({
                method: "POST",
                url: "{{ route('institutional.housing.store.v2') }}",
                data: {
                    _token: csrfToken,
                    without_doping: 1
                },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.status) {
                        $('.third-area').addClass('d-none');
                        $('.fourth-area').removeClass('d-none')

                        $('.firt-area').addClass('d-none');
                        $('.second-area').addClass('d-none');
                        $('.third-area').addClass('d-none');
                        $('.progress-line').removeClass('step1')
                        $('.progress-line').removeClass('step2')
                        $('.progress-line').removeClass('step3')
                        $('.fourth-area').removeClass('d-none');
                        $('.progress-line').addClass('step4')
                        $('.progress-line li').eq(0).removeClass('current').addClass('done')
                        $('.progress-line li').eq(1).removeClass('current').addClass('done')
                        $('.progress-line li').eq(2).removeClass('current').addClass('done')
                        $('.progress-line li').eq(3).addClass('current')
                    }
                }
            })
        })

        var houseCount = {{ isset($tempData->house_count) ? $tempData->house_count : 0 }};
        if (!isNaN(houseCount) && houseCount > 0) {
            var houseType = {{ isset($tempData->housing_type_id) ? $tempData->housing_type_id : 0 }};
            if (houseType != 0) {
                @if (isset($tempData->housing_type_id))
                    @php
                        $housingType = DB::table('housing_types')
                            ->where('id', $tempData->housing_type_id)
                            ->first();
                    @endphp
                    var housingTypeData = @json($housingType);
                    @if (isset($tempData->roomInfoKeys))
                        var oldData = @json($tempData->roomInfoKeys);
                    @else
                        var oldData = [];
                    @endif
                    var formInputs = JSON.parse(housingTypeData.form_json);
                @endif
                $('.rendered-area').removeClass('d-none')
                $.ajax({
                    method: "GET",
                    url: "{{ route('institutional.ht.getform') }}",
                    data: {
                        id: houseType
                    },
                    success: function(response) {
                        var html = "";
                        var htmlContent = "";
                        for (var i = 0; i < houseCount; i++) {
                            html +=
                                '<div class="item-left-area"><a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center ' +
                                (i == 0 ? 'active' : '') + '" id="Tab' + (i + 1) +
                                '" data-bs-toggle="tab" data-bs-target="#TabContent' + (i + 1) +
                                '" role="tab" aria-controls="TabContent' + (i + 1) + '" aria-selected="true">' +
                                '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>' +
                                '<span class="d-block d-sm-inline">' + (i + 1) +
                                ' Nolu Konut Bilgileri</span>' +
                                '<span class="d-block d-sm-inline">Kopyala (Aynı Olan Dairelere Otomatik Giriş) ' +
                                getCopyList(houseCount, i + 1) + '</span>' +
                                '</a></div>';

                            htmlContent += '<div class="tab-pane fade show ' + (i == 0 ? 'active' : '') +
                                '" id="TabContent' + (i + 1) + '" role="tabpanel">' +
                                '<div id="renderForm' + (i + 1) + '"></div>' +
                                '</div>';
                        }

                        $('#tablist').html(html);
                        $('.tab-content').html(htmlContent)

                        $('.item-left-area').click(function() {
                            console.log("asd");
                        })
                        for (let i = 1; i <= houseCount; i++) {
                            formRenderOpts = {
                                dataType: 'json',
                                formData: response.form_json
                            };

                            var renderedForm = $('<div>');
                            renderedForm.formRender(formRenderOpts);
                            var renderHtml = renderedForm.html().toString();
                            renderHtml = renderHtml.toString().split('images[][]');
                            renderHtml = renderHtml[0];
                            var json = JSON.parse(response.form_json);
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    var renderHtml = renderHtml.toString().split(json[lm].name + '[]');
                                    renderHtmlx = "";
                                    var json = JSON.parse(response.form_json);
                                    for (var t = 0; t < renderHtml.length; t++) {
                                        if (t != renderHtml.length - 1) {
                                            renderHtmlx += renderHtml[t] + (json[lm].name.split('[]')[0]) + i +
                                                '[][]';
                                        } else {
                                            renderHtmlx += renderHtml[t];
                                        }
                                    }

                                    renderHtml = renderHtmlx;
                                }
                            }
                            console.log(renderHtmlx);
                            $('#renderForm' + (i)).html(renderHtmlx);


                            $('#tablist a.nav-link').click(function(e) {
                                e.preventDefault(); // Linki tıklamayı engelleyin

                                // Tüm sekmeleri gizleyin
                                $('.tab-content .tab-pane').removeClass('show active');

                                // Tıklanan tab linkine ait tabın kimliğini alın
                                var tabId = $(this).attr('data-bs-target');

                                // İlgili tabı gösterin
                                $(tabId).addClass('show active');
                            });


                        }

                        $('.next_house').click(function() {
                            var nextHousing = true;
                            $('.tab-pane.active input[required="required"]').map((key, item) => {
                                if (!$(item).val()) {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })

                            $('.tab-pane.active select[required="required"]').map((key, item) => {
                                if (!$(item).val()) {
                                    nextHousing = false;
                                    $(item).addClass("error-border")
                                }
                            })
                            if ($('.tab-pane.active input[required="required"]').val() == "") {
                                nextHousing = false;
                                $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                            }
                            var indexItem = $('.tab-pane.active').index();
                            if (nextHousing) {
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                            } else {
                                $('html, body').animate({
                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                        $('.navbar-top').css('height'))
                                }, 100);
                            }
                        })

                        $('.prev_house').click(function() {

                            var indexItem = $('.tab-pane.active').index();
                            console.log(indexItem);
                            $('.tab-pane.active').removeClass('active');
                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                        })

                        $('.second-payment-plan').closest('div').addClass('d-none')
                        $('.tab-pane select[multiple="false"]').removeAttr('multiple')

                        $('input[value="taksitli"]').change(function() {
                            if ($(this).is(':checked')) {
                                $('.second-payment-plan').closest('div').removeClass('d-none');
                            } else {
                                $('.second-payment-plan').closest('div').addClass('d-none');
                            }
                        })

                        for (let i = 1; i <= houseCount; i++) {
                            for (var j = 0; j < formInputs.length; j++) {
                                if (formInputs[j].type == "number" || formInputs[j].type == "text") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    if (oldData[inputNamex[0]] != undefined) {
                                        console.log(oldData[
                                            inputNamex[0]][i - 1])
                                        $($('input[name="' + formInputs[j].name + '"]')[i - 1]).val(oldData[
                                            inputNamex[0]][i - 1]);
                                    }
                                } else if (formInputs[j].type == "select") {
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    $($('select[name="' + formInputs[j].name + '"]')[i - 1]).children('option')
                                        .map((key, item) => {
                                            if (oldData[inputNamex[0]] != undefined) {
                                                if ($(item).attr("value") == oldData[inputNamex[0]][i -
                                                        1
                                                    ]) {
                                                    $(item).attr('selected', 'selected')
                                                } else {
                                                    $(item).removeAttr('selected')
                                                }
                                            } else {
                                                $(item).removeAttr('selected')
                                            }

                                        });
                                } else if(formInputs[j].type == 'checkbox-group'){
                                    var inputName = formInputs[j].name;
                                    var inputNamex = inputName;
                                    inputNamex = inputNamex.split('[]')
                                    var checkboxName = inputName;
                                    checkboxName = checkboxName.split('[]');
                                    checkboxName = checkboxName[0];
                                    $($('input[name="'+checkboxName+[i]+'[][]"]')).map((key,item) => {
                                        
                                    if(oldData[inputNamex[0]+(i)]){
                                        oldData[inputNamex[0]+(i)].map((checkbox) => {
                                            if(checkbox){
                                                if(checkbox.trim() == $(item).attr("value").trim()){
                                                    $(item).attr('checked','checked')
                                                }
                                            }
                                        })
                                    }
                                    
                                    });
                                }

                            }
                        }

                        $('.dropzonearea').closest('.formbuilder-file').remove();
                        for (let i = 1; i <= houseCount; i++) {
                            var images = '';
                            if (oldData.images) {
                                housingImages = JSON.parse(oldData.images[i - 1]);
                            } else {
                                housingImages = [];
                            }
                            for (let j = 0; j < housingImages.length; j++) {
                                images +=
                                    '<div class="project_images_area"><img class="edit_project_housing_image" src="{{ URL::to('/') . '/project_images/' }}' +
                                    housingImages[j] + '"> <span order="' + j + '" housing_order="' + i +
                                    '" class="btn btn-danger remove_housing_image">Sil</span>  </div>';
                            }
                            $('.dropzone2').eq(i - 1).parent('div').append(
                                '<div class="d-none"><input housing_order="' + i +
                                '" type="file" class="new_file_on_drop"></div>')
                            $('.dropzone2').eq(i - 1).html(images);
                        }

                        var csrfToken = "{{ csrf_token() }}";

                        $('.add-new-project-house-image').click(function() {
                            $(this).parent('div').find('.new_file_on_drop').trigger("click")
                        })


                        $('.disabled-housing').closest('.form-group').remove();

                        @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
                            @if($tempData->step2_slug == "kiralik")
                                $('.rent-disabled').closest('.form-group').remove();
                            @endif
                        @endif

                        @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
                            @if($tempData->step2_slug == "satilik")
                                $('.project-disabled').closest('.form-group').remove();
                            @endif
                        @endif

                        @if(isset($tempDataFull->data) && isset($tempData->step1_slug) && isset($tempData->step2_slug) && $tempData->step1_slug && $tempData->step2_slug)
                            @if($tempData->step2_slug == "gunluk-kiralik")
                                $('.daily-rent-disabled').closest('.form-group').remove();
                            @endif
                        @endif

                        $('.copy-item').change(function() {
                            var order = parseInt($(this).val()) - 1;
                            var currentOrder = parseInt($(this).closest('a').attr('data-bs-target')
                                .replace('#TabContent', '')) - 1;
                            for (var lm = 0; lm < json.length; lm++) {
                                if (json[lm].type == "checkbox-group") {
                                    for (var i = 0; i < json[lm].values.length; i++) {
                                        var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                '')) + (order + 1) + '[][]"][value="' + json[lm]
                                            .values[i].value + '"]' + '').is(':checked')
                                        if (isChecked) {
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', true)
                                        } else {
                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').prop('checked', false)
                                        }
                                    }
                                } else if (json[lm].type == "select") {
                                    var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                        .val();
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option').removeAttr('selected')
                                    console.log($('select[name="' + (json[lm].name) + '"]').eq(
                                        currentOrder).children('option[value="' + value[0] +
                                        '"]'));
                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                        .children('option[value="' + value[0] + '"]').prop('selected',
                                            true);
                                } else if (json[lm].type == "file" && json[lm].name == "image[]") {
                                    var files = $('input[name="' + (json[lm].name) + '"]').eq(order)[0]
                                        .files;
                                    var input2 = $('input[name="' + (json[lm].name) + '"]').eq(
                                        currentOrder);
                                    for (var i = 0; i < files.length; i++) {
                                        var file = files[i];
                                        input2.prop("files", files);
                                    }
                                } else if (json[lm].type != "file") {
                                    var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                        .val();
                                    console.log($('input[name="' + (json[lm].name) + '"]').eq(order)
                                        .val());
                                    $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                        value);
                                }
                            }
                        })

                        $('.rendered-form input').change(function() {
                            console.log("asd");
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value', $(this).val());
                            console.log($(this).closest('.tab-pane').attr('id'))
                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                .replace('TabContent', "")) - 1);
                            formData.append('key', $(this).attr('name').replace("[]", "").replace("[]",
                                ""));
                            formData.append('item_type', 2);
                            if($(this).hasClass('only-one')){
                                formData.append('only-one',"1");
                                $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                            }
                            if ($(this).attr('type') == "checkbox") {
                                formData.append('checkbox', "1");
                            }
                            $.ajax({
                                type: "POST",
                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {},
                            });
                        })

                        $('.rendered-form select').change(function() {
                            console.log("asd");
                            var formData = new FormData();
                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                            formData.append('_token', csrfToken);
                            formData.append('value', $(this).val());
                            console.log($(this).closest('.tab-pane').attr('id'))
                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                .replace('TabContent', "")) - 1);
                            formData.append('key', $(this).attr('name').replace("[]", ""));
                            formData.append('item_type', 2);
                            $.ajax({
                                type: "POST",
                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                data: formData,
                                processData: false,
                                contentType: false,
                                success: function(response) {},
                            });
                        })

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

                        $('.maks-3').keyup(function(){
                            console.log("asd")
                            if(parseInt($(this).val()) > 3){
                                $(this).val(3);
                            }
                        })

                        $('.number-only').keyup(function() {
                            $('.number-only .error-text').remove();
                            if ($(this).val() != parseInt($(this).val())) {
                                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                    $(this).val("");
                                } else {
                                    $(this).closest('.form-group').append(
                                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                    )
                                    $(this).val("");
                                }

                            } else {
                                $(this).closest('.form-group').find('.error-text').remove();
                            }
                        })

                        $('.formbuilder-text input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })

                        $('.formbuilder-number input').change(function() {
                            if ($(this).val() != "") {
                                $(this).removeClass('error-border')
                            }
                        })

                        $('.cover-image-by-housing-type').closest('.formbuilder-file').remove();
                    },
                    error: function(error) {
                        console.log(error)
                    }
                })
            }

        }

        function changeData(value, key, isArray = 0) {
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value', value);
            formData.append('key', key);
            formData.append('item_type', 2);
            formData.append('array_data', isArray);
            $.ajax({
                type: "POST",
                url: "{{ route('institutional.temp.order.data.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (key == 'pricing-type') {
                        if (value == 2) {
                            $('.single-price-project-area').removeClass('d-none')
                            $('.pricing-select-first').addClass('d-none')
                        } else {
                            $('.single-price-project-area').addClass('d-none')
                        }
                    }
                },
            });
        }

        $('.redirect-back-pricing').click(function() {
            $('.single-price-project-area').addClass('d-none')
            $('.pricing-select-first').removeClass('d-none')
        })

        $('.photo-area').click(function() {
            $('.project_image.d-none').trigger('click');
        })

        $('.cover-photo-area').click(function() {
            $('.cover_image.d-none').trigger('click');
        })

        $('.cover-document-area').click(function() {
            $('.document.d-none').trigger('click');
        })

        $('.document').change(function() {
            var input = this;
            if (input.files && input.files[0]) {
                $('.cover-document-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('document', this.files[0]);
                formData.append('item_type', 2);
                $.ajax({
                    type: "POST",
                    url: "{{ route('institutional.temp.order.document.add') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response.status) {
                            var html = '<div class="has_file">' +
                                '<span class="d-block">Dosya Eklediniz</span>' +
                                '<a class="btn btn-info" href="{{ URL::to('/') }}/housing_documents/' +
                                response.document_name + '" download="">Mevcut Dosyayı İndir</a>' +
                                '</div>';

                            $('.cover-document').html(html);
                        }
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });

            }
        });

        $('.cover_image').change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                $('.cover-photo-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('image', this.files[0]);
                formData.append('item_type', 2);
                $.ajax({
                    type: "POST",
                    url: "{{ route('institutional.temp.order.single.file.add') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Dosya yükleme başarılı ise sunucudan gelen yanıtı görüntüle
                        $("#sonuc").html(response);
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                reader.onload = function(e) {
                    // Resmi görüntülemek için bir div oluşturun
                    var imageDiv = $('<div class="project_imagex"></div>');

                    // Resmi oluşturun ve div içine ekleyin
                    var image = $('<img>').attr('src', e.target.result);
                    imageDiv.append(image);
                    // Resmi görüntüleyici divini temizleyin ve yeni resmi ekleyin
                    $('.cover-photo').html(imageDiv);

                    $('.cover-photo').on('click', '.fa-trash', function() {
                        var imageDiv = $(this).parent(); // Tıklanan resmin üst öğesini al

                        // Kullanıcıdan resmi silmek istediğine emin misiniz diye sorabilirsiniz
                        var confirmation = confirm("Bu resmi silmek istediğinizden emin misiniz?");

                        if (confirmation) {
                            imageDiv.remove(); // Resmi kaldır
                        }
                    });
                };

                // Resmi okuyun
                reader.readAsDataURL(input.files[0]);
            }
        });

        $('.project_image').change(function() {
            var input = this;

            if (input.files && input.files[0]) {
                $('.photo-area').removeClass('error-border')

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('item_type',2);
                for (let i = 0; i < this.files.length; i++) {
                    formData.append(`file${i}`, this.files[i]);
                }
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.image.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        
                        for (let i = 0; i < response.length; i++) {
                            var imageDiv = $('<div class="project_imagex" order="'+response[i]+'"></div>');
                            var image = $('<img>').attr('src', '{{URL::to('/')}}/project_images/'+response[i]);
                            var imageButtons = $('<div>').attr('class','image-buttons');
                            var imageButtonsIcon = $('<i>').attr('class','fa fa-trash');
                            imageButtons.append(imageButtonsIcon)
                            imageDiv.append(image);
                            imageDiv.append(imageButtons);
                            $('.photos').append(imageDiv);

                            $('.project_imagex .image-buttons').click(function(){
                                var thisx = $(this);
                                $.ajax({
                                    url: '{{route("institutional.delete.image.order.temp.update")}}',
                                    type: 'POST',
                                    data: { 
                                        image: $(this).closest('.project_imagex').attr('order') ,
                                        item_type : 2,
                                        _token : csrfToken
                                    },
                                    success: function(response) {
                                        thisx.closest('.project_imagex').remove()
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                                    }
                                });
                            })
                        }
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                

            }
        });

        $('.finish-tick').click(function() {
            console.log($(this).find('input').is(':checked'));
            if ($(this).find('input').is(':checked')) {
                $(this).find('input').prop('checked', false)
            } else {
                $('.finish-tick').removeClass('error-border')
                $(this).find('input').prop('checked', true)
            }
        })

        $('.pricing-item').click(function() {
            $('.pricing-item').find('input').removeAttr('checked');
            $('.pricing-item').find('.price-radio').removeClass('select');
            $(this).find('input').attr('checked', 'checked');
            $(this).find('.price-radio').addClass('select')
            $('.single-price-project-area .error-text').remove()
        })

        $('.pricing-item-first').click(function() {
            $('.pricing-item-first').find('input').removeAttr('checked');
            $('.pricing-item-first').find('.price-radio').removeClass('select');
            $(this).find('input').attr('checked', 'checked');
            $(this).find('.price-radio').addClass('select')
            $('.pricing-select-first .error-text').remove();
        })

        $('.photo-area').click(function() {

        })

        function getCopyList(housingCount, currentItemKey) {
            var html = '<select class="copy-item"><option value="">Daire bilgilerini kopyala</option>'
            for (var i = 1; i <= housingCount; i++) {
                if (i != currentItemKey) {
                    html += '<option value="' + i + '">Daire ' + i + '</option>'
                }
            }

            html += '</select>'

            return html;
        }

        jQuery($ => {
            var houseCount = {{ old('house_count') ? old('house_count') : 0 }};
            if (!isNaN(houseCount) && houseCount > 0) {
                var houseType = {{ old('housing_type') ? old('housing_type') : 0 }};
                if (houseType != 0) {
                    @php
                        $housingType = DB::table('housing_types')
                            ->where('id', old('housing_type'))
                            ->first();
                    @endphp
                    var housingTypeData = @json($housingType);
                    var oldData = @json(old());
                    console.log(oldData);
                    var formInputs = JSON.parse(housingTypeData.form_json);

                    $('.rendered-area').removeClass('d-none')
                    $.ajax({
                        method: "GET",
                        url: "{{ route('institutional.ht.getform') }}",
                        data: {
                            id: houseType
                        },
                        success: function(response) {
                            var html = "";
                            var htmlContent = "";
                            for (var i = 0; i < houseCount; i++) {
                                html +=
                                    '<a class="nav-link border-end border-end-sm-0 border-bottom-sm border-300 text-center text-sm-start cursor-pointer outline-none d-sm-flex align-items-sm-center ' +
                                    (i == 0 ? 'active' : '') + '" id="Tab' + (i + 1) +
                                    '" data-bs-toggle="tab" data-bs-target="#TabContent' + (i + 1) +
                                    '" role="tab" aria-controls="TabContent' + (i + 1) +
                                    '" aria-selected="true">' +
                                    '<span class="me-sm-2 fs-4 nav-icons" data-feather="tag"></span>' +
                                    '<span class="d-none d-sm-inline">' + (i + 1) +
                                    ' Nolu Konut Bilgileri</span>' +
                                    '</a>';

                                htmlContent += '<div class="tab-pane fade show ' + (i == 0 ? 'active' :
                                        '') + '" id="TabContent' + (i + 1) + '" role="tabpanel">' +
                                    '<div id="renderForm' + (i + 1) + '"></div>' +
                                    '</div>';
                            }

                            $('#tablist').html(html);
                            $('.tab-content').html(htmlContent)
                            for (let i = 1; i <= houseCount; i++) {
                                formRenderOpts = {
                                    dataType: 'json',
                                    formData: response.form_json
                                };

                                var renderedForm = $('<div>');
                                renderedForm.formRender(formRenderOpts);
                                var renderHtml = renderedForm.html().toString();
                                renderHtml = renderHtml.toString().split('images[][]');
                                renderHtml = renderHtml[0];
                                var json = JSON.parse(response.form_json);
                                for (var lm = 0; lm < json.length; lm++) {
                                    if (json[lm].type == "checkbox-group") {
                                        var renderHtml = renderHtml.toString().split(json[lm].name +
                                            '[]');
                                        renderHtmlx = "";
                                        var json = JSON.parse(response.form_json);
                                        for (var t = 0; t < renderHtml.length; t++) {
                                            if (t != renderHtml.length - 1) {
                                                renderHtmlx += renderHtml[t] + (json[lm].name.split(
                                                    '[]')[0]) + i + '[][]';
                                            } else {
                                                renderHtmlx += renderHtml[t];
                                            }
                                        }

                                        renderHtml = renderHtmlx;
                                    }
                                }
                                $('#renderForm' + (i)).html(renderHtmlx);
                                $('#tablist a.nav-link').click(function(e) {
                                    e.preventDefault(); // Linki tıklamayı engelleyin

                                    // Tüm sekmeleri gizleyin
                                    $('.tab-content .tab-pane').removeClass('show active');

                                    // Tıklanan tab linkine ait tabın kimliğini alın
                                    var tabId = $(this).attr('data-bs-target');

                                    // İlgili tabı gösterin
                                    $(tabId).addClass('show active');
                                });

                            }
                            for (let i = 1; i <= houseCount; i++) {
                                for (var j = 2; j < formInputs.length; j++) {
                                    if (formInputs[j].type == "number" || formInputs[j].type ==
                                        "text") {
                                        var inputName = formInputs[j].name;
                                        var inputNamex = inputName;
                                        inputNamex = inputNamex.split('[]')
                                        console.log(inputNamex);
                                        $($('input[name="' + formInputs[j].name + '"]')[i - 1]).val(
                                            oldData[inputNamex[0]][i - 1]);
                                    } else if (formInputs[j].type == "select") {
                                        var inputName = formInputs[j].name;
                                        var inputNamex = inputName;
                                        inputNamex = inputNamex.split('[]')
                                        $($('select[name="' + formInputs[j].name + '"]')[i - 1])
                                            .children('option').map((key, item) => {
                                                if ($(item).attr("value") == oldData[inputNamex[0]][
                                                        i - 1
                                                    ]) {
                                                    $(item).attr('selected', 'selected')
                                                } else {
                                                    $(item).removeAttr('selected')
                                                }
                                            });
                                    } else if (formInputs[j].type == 'checkbox-group') {
                                        var inputName = formInputs[j].name;
                                        var inputNamex = inputName;
                                        inputNamex = inputNamex.split('[][]')
                                        var checkboxName = inputName;
                                        checkboxName = checkboxName.split('[]');
                                        checkboxName = checkboxName[0];
                                        $($('input[name="' + checkboxName + [i] + '[][]"]')).map((key,
                                            item) => {
                                            console.log(oldData[(checkboxName + i)], $(item)
                                                .attr("value"))
                                            oldData[(checkboxName + i)].map((checkbox) => {
                                                if (checkbox[0] == $(item).attr(
                                                        "value")) {
                                                    $(item).attr('checked', 'checked')
                                                }
                                            })
                                        });
                                    }

                                }
                            }





                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                }

            }




            const houseCountInput = document.getElementById('house_count');
            const generateTabsButton = document.getElementById('generate_tabs');
            const tabsContainer = document.getElementById('tabs');

        });

        @if (isset($tempData->city_id))
            var selectedCity = {{ $tempData->city_id }}; // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{ route('institutional.get.counties') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    city: selectedCity
                }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#counties'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle
                    var countyId =
                        @if (isset($tempData->county_id))
                            {{ $tempData->county_id }}
                        @else
                            null
                        @endif
                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].ilce_key, // İlçe ID'si
                            text: response[i].ilce_title, // İlçe adı
                            key_x: response[i].key_x,
                            selected: (response[i].ilce_key == countyId ? true : false)
                        }));
                    }

                    @if (isset($tempData->county_id))
                        var selectedCounty = {{ $tempData->county_id }}; // Seçilen şehir değerini al
                        var selectedCountyKey = $('#counties option[value="' + selectedCounty + '"]').attr(
                            "key_x");
                        // AJAX isteği yap

                        $.ajax({
                            url: '{{ route('institutional.get.neighbourhood') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                            method: 'GET',
                            data: {
                                county_id: selectedCounty
                            }, // Şehir verisini isteğe ekle
                            dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                            success: function(response) {
                                // Yanıt başarılı olduğunda çalışacak kod
                                var countiesSelect = $(
                                    '#neighbourhood'); // counties id'li select'i seç
                                countiesSelect.empty(); // Select içeriğini temizle
                                var countyId =
                                    @if (isset($tempData->neighbourhood_id))
                                        {{ $tempData->neighbourhood_id }}
                                    @else
                                        null
                                    @endif

                                for (var i = 0; i < response.length; i++) {
                                    countiesSelect.append($('<option>', {
                                        value: response[i].mahalle_id, // İlçe ID'si
                                        text: response[i].mahalle_title, // İlçe adı
                                        selected: (response[i].mahalle_id == countyId ?
                                            true : false)
                                    }));
                                }
                            },
                            error: function(xhr, status, error) {
                                // Hata durumunda çalışacak kod
                                console.error('Hata: ' + error);
                            }
                        });
                    @endif
                },
                error: function(xhr, status, error) {
                    // Hata durumunda çalışacak kod
                    console.error('Hata: ' + error);
                }
            });
        @endif

        $('#cities').change(function() {
            var selectedCity = $(this).val(); // Seçilen şehir değerini al

            // AJAX isteği yap
            $.ajax({
                url: '{{ route('institutional.get.counties') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    city: selectedCity
                }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#counties'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle

                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].ilce_key, // İlçe ID'si
                            text: response[i].ilce_title, // İlçe adı
                            key_x: response[i].key_x,
                        }));
                    }


                },
                error: function(xhr, status, error) {
                    // Hata durumunda çalışacak kod
                    console.error('Hata: ' + error);
                }
            });
        });

        $('#counties').change(function() {
            var selectedCounty = $(this).val(); // Seçilen şehir değerini al
            console.log(selectedCounty);
            var selectedCountyKey = $('#counties option[value="' + selectedCounty + '"]').attr("key_x");
            // AJAX isteği yap
            $.ajax({
                url: '{{ route('institutional.get.neighbourhood') }}', // Endpoint URL'si (get.counties olarak varsayalım)
                method: 'GET',
                data: {
                    county_id: selectedCounty
                }, // Şehir verisini isteğe ekle
                dataType: 'json', // Yanıtın JSON formatında olduğunu belirt
                success: function(response) {
                    // Yanıt başarılı olduğunda çalışacak kod
                    var countiesSelect = $('#neighbourhood'); // counties id'li select'i seç
                    countiesSelect.empty(); // Select içeriğini temizle

                    countiesSelect.append($('<option>', {
                        value: "", // İlçe ID'si
                        text: "Mahalle Seç" // İlçe adı
                    }));
                    // Dönen yanıttaki ilçeleri döngüyle ekleyin
                    for (var i = 0; i < response.length; i++) {
                        countiesSelect.append($('<option>', {
                            value: response[i].mahalle_id, // İlçe ID'si
                            text: response[i].mahalle_title // İlçe adı
                        }));
                    }
                },
                error: function(xhr, status, error) {
                    // Hata durumunda çalışacak kod
                    console.error('Hata: ' + error);
                }
            });
        });
    </script>
    <script src="{{URL::to('/')}}/adminassets/rich-editor/jquery.richtext.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#editor').richText({
                saveOnBlur : 1,
                saveCallback: function (editor, source, content) {

                    const editorContent = content;
                    console.log(editorContent);
                    if(editorContent != ""){
                        descriptionText = "evet var";
                    }else{
                        descriptionText = "";
                    }
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
                    
                    
                    // Verileri FormData nesnesine ekleyin
                    const formData = new FormData();
                    formData.append('_token', csrfToken);
                    formData.append('value', editorContent);
                    formData.append('key', "description");
                    formData.append('item_type', 2);
                    
                    // AJAX isteği gönderin
                    fetch("{{ route('institutional.temp.order.data.change') }}", {
                        method: "POST",
                        body: formData,
                    })
                    .then(data => {
                        // Sunucu yanıtını işleyebilirsiniz.
                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
            });
        })

        function allowDrop(event) {
            event.preventDefault();
        }

        function handleDrop(event) {
            event.preventDefault();

            var files = event.dataTransfer.files;
            console.log(event);
            if (files.length > 0) {
                handleDroppedFiles(files);
            }
        }

        function handleDroppedFiles(files) {
            var input = this;

            if (files.length > 0) {
                $('.cover-photo-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('image',files[0]);
                formData.append('item_type',2);
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.single.file.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Dosya yükleme başarılı ise sunucudan gelen yanıtı görüntüle
                        $("#sonuc").html(response);
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                reader.onload = function(e) {
                    // Resmi görüntülemek için bir div oluşturun
                    var imageDiv = $('<div class="project_imagex"></div>');

                    // Resmi oluşturun ve div içine ekleyin
                    var image = $('<img>').attr('src', e.target.result);
                    imageDiv.append(image);
                    // Resmi görüntüleyici divini temizleyin ve yeni resmi ekleyin
                    $('.cover-photo').html(imageDiv);

                    $('.cover-photo').on('click', '.fa-trash', function() {
                        var imageDiv = $(this).parent(); // Tıklanan resmin üst öğesini al

                        // Kullanıcıdan resmi silmek istediğine emin misiniz diye sorabilirsiniz
                        var confirmation = confirm("Bu resmi silmek istediğinizden emin misiniz?");
                        
                        if (confirmation) {
                            imageDiv.remove(); // Resmi kaldır
                        }
                    });
                    
                };

                // Resmi okuyun
                reader.readAsDataURL(files[0]);
            }
            
        }

        function allowDrop2(event) {
            event.preventDefault();
        }

        function handleDrop2(event) {
            event.preventDefault();

            var files = event.dataTransfer.files;
            console.log(event);
            if (files.length > 0) {
                handleDroppedFiles2(files);
            }
        }

        function handleDroppedFiles2(files) {
            console.log(files)
            if (files && files[0]) {
                $('.photo-area').removeClass('error-border')

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('item_type',2);
                for (let i = 0; i < files.length; i++) {
                    console.log(files[i]);
                    formData.append(`file${i}`, files[i]);
                }
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.image.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        
                        for (let i = 0; i < response.length; i++) {
                            var imageDiv = $('<div class="project_imagex" order="'+response[i]+'"></div>');
                            var image = $('<img>').attr('src', '{{URL::to('/')}}/project_images/'+response[i]);
                            var imageButtons = $('<div>').attr('class','image-buttons');
                            var imageButtonsIcon = $('<i>').attr('class','fa fa-trash');
                            imageButtons.append(imageButtonsIcon)
                            imageDiv.append(image);
                            imageDiv.append(imageButtons);
                            $('.photos').append(imageDiv);

                            $('.project_imagex .image-buttons').click(function(){
                                var thisx = $(this);
                                $.ajax({
                                    url: '{{route("institutional.delete.image.order.temp.update")}}',
                                    type: 'POST',
                                    data: { 
                                        image: $(this).closest('.project_imagex').attr('order') ,
                                        item_type : 1,
                                        _token : csrfToken
                                    },
                                    success: function(response) {
                                        thisx.closest('.project_imagex').remove()
                                    },
                                    error: function(xhr, status, error) {
                                        console.error("Ajax isteği sırasında bir hata oluştu: " + error);
                                    }
                                });
                            })
                        }
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                

            }
            
        }

        function allowDrop3(event) {
            event.preventDefault();
        }

        function handleDrop3(event) {
            event.preventDefault();

            var files = event.dataTransfer.files;
            console.log(event);
            if (files.length > 0) {
                handleDroppedFiles3(files);
            }
        }

        function handleDroppedFiles3(files) {
            if (files && files[0]) {
                $('.cover-document-area').removeClass('error-border')
                var reader = new FileReader();

                var formData = new FormData();
                var csrfToken = $("meta[name='csrf-token']").attr("content");
                formData.append('_token', csrfToken);
                formData.append('document',files[0]);
                formData.append('item_type',2);
                $.ajax({
                    type: "POST",
                    url: "{{route('institutional.temp.order.document.add')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        response = JSON.parse(response);

                        if(response.status){
                            var html = '<div class="has_file">'+
                                '<span class="d-block">Dosya Eklediniz</span>'+
                                '<a class="btn btn-info" href="{{URL::to("/")}}/housing_documents/'+response.document_name+'" download="">Mevcut Dosyayı İndir</a>'+
                            '</div>';

                            $('.cover-document').html(html);
                        }
                    },
                    error: function() {
                        // Hata durumunda kullanıcıya bir mesaj gösterebilirsiniz
                        alert("Dosya yüklenemedi.");
                    }
                });
                
            }
        }

        $('.finish-buttonx').click(function(e) {
            e.preventDefault();
            var next = true;
            var topError = 0;
            if (!$('input[name="name"]').val()) {
                next = false;
                $('input[name="name"]').addClass('error-border')
                topError = $('input[name="name"]').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
            }

            $.ajax({
                method: "GET",
                url: "{{ route('institutional.temp.order.location.control') }}",
                data: {
                    item_type: 2,
                    _token: csrfToken
                },
                success: function(response) {
                    if(!response){
                        $('#mapContainer').parent('div').prepend('<div style="border-radius:0;color:#fff;" class="alert alert-danger">Haritada konumu seçmeniz gerekiyor</div>')
                        topError = $('#mapContainer').offset().top - parseFloat($('.navbar-top').css( 'height')) - 100;
                        
                    }else{
                        $('#mapContainer').parent('div').find('.alert-danger').remove();
                    }

                    if (!$('#location').val()) {
                        next = false;
                        if (topError) {
                            if ($('#location').parent('div').offset().top - parseFloat($('.navbar-top').css('height')) -
                                100 < topError) {
                                topError = $('#location').parent('div').offset().top - parseFloat($('.navbar-top').css(
                                    'height')) - 100;
                            }
                        } else {
                            topError = $('#location').parent('div').offset().top - parseFloat($('.navbar-top').css(
                                'height')) - 100;
                        }
                        $('#location').parent('div').find('.error-text').remove();
                        $('#location').parent('div').append(
                            '<span class="error-text">Haritadan konum seçmek zorunludur</span>')
                    }

                    if (!$('.rules_confirm').is(':checked')) {
                        next = false;

                        if (topError) {
                            if ($('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                topError) {
                                topError = $('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) -
                                    100;
                            }
                        } else {
                            topError = $('.finish-tick').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                        }
                        $('.finish-tick').addClass('error-border')
                    }

                    if (descriptionText == "") {
                        next = false;
                        if (topError) {
                            if ($('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                topError) {
                                topError = $('.description-field').offset().top - parseFloat($('.navbar-top').css(
                                    'height')) - 100;
                            }
                        } else {
                            topError = $('.description-field').offset().top - parseFloat($('.navbar-top').css('height')) -
                                100;
                        }
                        $('.description-field .error-text').remove();
                        $('.description-field').append('<span class="error-text">Açıklama metnini girmek zorunludur</span>')
                    }

                    $('.tab-pane.active input[required="required"]').map((key, item) => {
                        if (!$(item).val()) {
                            next = false;

                            if (topError) {
                                if ($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                    topError) {
                                    topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) -
                                        100;
                                }
                            } else {
                                topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                            }
                            $(item).addClass("error-border")
                        }
                    })

                    $('.tab-pane.active select[required="required"]').map((key, item) => {
                        if (!$(item).val() || $(item).val() == "Seçiniz") {
                            next = false;
                            if (topError) {
                                if ($(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                    topError) {
                                    topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) -
                                        100;
                                }
                            } else {
                                topError = $(item).offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                            }
                            $(item).addClass("error-border")
                        }
                    })

                    if ($('.photos .project_imagex').length == 0) {
                        next = false;
                        if (topError) {
                            if ($('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                topError) {
                                topError = $('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                            }
                        } else {
                            topError = $('.photo-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                        }
                        $('.photo-area').addClass('error-border')
                    }

                    if ($('.cover-photo .project_imagex').length == 0) {
                        next = false;
                        if (topError) {
                            if ($('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                topError) {
                                topError = $('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) -
                                    100;
                            }
                        } else {
                            topError = $('.cover-photo').offset().top - parseFloat($('.navbar-top').css('height')) - 100;
                        }
                        $('.cover-photo-area').addClass('error-border')
                    }

                    if ($('.cover-document .has_file').length == 0) {
                        next = false;
                        if (topError) {
                            if ($('.cover-document-area').offset().top - parseFloat($('.navbar-top').css('height')) - 100 <
                                topError) {
                                topError = $('.cover-document-area').offset().top - parseFloat($('.navbar-top').css(
                                    'height')) - 100;
                            }
                        } else {
                            topError = $('.cover-document-area').offset().top - parseFloat($('.navbar-top').css('height')) -
                                100;
                        }
                        $('.cover-document-area').addClass('error-border')
                    }

                    if (!$('select[name="city_id"]').val()) {
                        next = false;
                        if (topError) {
                            if ($('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css('height')) -
                                100 < topError) {
                                topError = $('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css(
                                    'height')) - 100;
                            }
                        } else {
                            topError = $('select[name="city_id"]').offset().top - parseFloat($('.navbar-top').css(
                                'height')) - 100;
                        }
                        $('select[name="city_id"]').addClass('error-border')
                    }

                    if (!$('select[name="county_id"]').val()) {
                        next = false;
                        if (topError) {
                            if ($('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css('height')) -
                                100 < topError) {
                                topError = $('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css(
                                    'height')) - 100;
                            }
                        } else {
                            topError = $('select[name="county_id"]').offset().top - parseFloat($('.navbar-top').css(
                                'height')) - 100;
                        }
                        $('select[name="county_id"]').addClass('error-border')
                    }

                    if (!$('select[name="neighbourhood_id"]').val()) {
                        next = false;
                        if (topError) {
                            if ($('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css(
                                    'height')) - 100 < topError) {
                                topError = $('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top')
                                    .css('height')) - 100;
                            }
                        } else {
                            topError = $('select[name="neighbourhood_id"]').offset().top - parseFloat($('.navbar-top').css(
                                'height')) - 100;
                        }
                        $('select[name="neighbourhood_id"]').addClass('error-border')
                    }

                    if (next) {
                        nextTemp = true;
                        $.ajax({
                            method: "POST",
                            url: "{{ route('institutional.change.step.order') }}",
                            data: {
                                order: 3,
                                item_type: 2,
                                _token: csrfToken
                            },
                            success: function(response) {
                                response = JSON.parse(response);
                                if (response.status) {
                                    $('.firt-area').addClass('d-none');
                                    $('.second-area').addClass('d-none');
                                    $('.third-area').addClass('d-none');
                                    $('.progress-line').removeClass('step1')
                                    $('.progress-line').removeClass('step2')
                                    $('.progress-line').removeClass('step3')
                                    $('.third-area').removeClass('d-none');
                                    $('.progress-line').addClass('step3')
                                    $('.progress-line li').eq(0).removeClass('current').addClass('done')
                                    $('.progress-line li').eq(1).removeClass('current').addClass('done')
                                    $('.progress-line li').eq(2).addClass('current')
                                }

                            }
                        })
                    } else {
                        nextTemp = false;
                        $('html, body').animate({
                            scrollTop: topError
                        }, 100);
                    }
                }
            })


            
        })
        var itemOrder = 0;
        var itemSlug = "";
        var areasSlugs = [];
        $('.area-listx li').click(function(){
            $('.area-listx li').removeClass('selected');
            var thisx = $(this);
            var value = $(this).attr('attr-id');
            var key = "statuses";
            var isArray = 1; 
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value',value);
            formData.append('key',key);
            formData.append('item_type',2);
            formData.append('array_data',isArray);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.data.change')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    changeData("",'step3_slug')
                    changeData("",'step2_slug')
                    changeData("",'step1_slug')
                    thisx.addClass('selected')
                    $('.area-list').removeClass('active');
                    $('.area-list').eq(0).addClass('active')
                    $('.area-list').eq(0).find('li').removeClass('selected');
                },
            });
        })

        $('.area-list').eq(0).find('li').click(function(){
            itemSlug = $(this).attr('slug');
            var thisx = $(this);
            
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append("key","step1_slug");
            formData.append("value",itemSlug);
            formData.append("item_type",2);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(key == 'pricing-type'){
                        if(value == 2){
                            $('.single-price-project-area').removeClass('d-none')
                            $('.pricing-select-first').addClass('d-none')
                        }else{
                            $('.single-price-project-area').addClass('d-none')
                        }
                    }
                },
            });
            $('.breadcrumb').find('.breadcrumb-after-item').remove()
            $('.breadcrumb').find('.breadcrumb-after-item').remove()
            $('.breadcrumb').find('.breadcrumb-after-item').remove()
            $('.breadcrumb').append('<span class="breadcrumb-after-item">'+($(this).html())+'</span>')
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            $.ajax({
                url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    $('.area-list').eq(0).find('li').removeClass('selected');
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                    }
                    $('.area-list').eq(1).children('ul').html(list)

                    $('.area-list').eq(1).addClass('active');
                    thisx.addClass('selected');
                    thisx.find('.loading-icon').remove();

                    $('.area-list').eq(2).removeClass('active');
                    $('.area-list').eq(3).removeClass('active');

                    $('.area-list').eq(1).find('li').click(function(){
                        itemSlug = $(this).attr('slug');
                        if(itemSlug == "kiralik"){
                            isRent = true;
                        }else{
                            isRent = false;
                        }

                        if(itemSlug == "gunluk-kiralik"){
                            isDailyRent = true;
                        }else{
                            isDailyRent = false;
                        }

                        if(itemSlug == "satilik"){
                            isSale = true;
                        }else{
                            isSale = false;
                        }
                        var thisx = $(this);
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append("key","step2_slug");
                        formData.append("value",itemSlug);
                        formData.append("item_type",2);
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if(key == 'pricing-type'){
                                    if(value == 2){
                                        $('.single-price-project-area').removeClass('d-none')
                                        $('.pricing-select-first').addClass('d-none')
                                    }else{
                                        $('.single-price-project-area').addClass('d-none')
                                    }
                                }
                            },
                        });
                        $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
                        $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
                        $('.breadcrumb').append('<span class="breadcrumb-after-item">'+($(this).html())+'</span>')
                        $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                        $.ajax({
                            url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug+'?parent_slug='+$('.area-list').eq(0).find('li.selected').attr('slug'), // AJAX isteği yapılacak URL
                            type: "GET", // GET isteği
                            dataType: "json", // Gelen veri tipi JSON
                            success: function (data) {
                                $('.area-list').eq(1).find('li').removeClass('selected');
                                $('.area-list').eq(3).removeClass('active');
                                data = data.data;
                                var list = "";
                                for(var i = 0 ; i < data.length; i++){
                                    list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                                }
                                $('.area-list').eq(2).children('ul').html(list)

                                $('.area-list').eq(2).addClass('active');
                                thisx.addClass('selected');
                                thisx.find('.loading-icon').remove();

                                $('.area-list').eq(2).find('li').click(function(){
                                    itemSlug = $(this).attr('slug');
                                    var thisx = $(this);
                                    var formData = new FormData();
                                    var csrfToken = $("meta[name='csrf-token']").attr("content");
                                    formData.append('_token', csrfToken);
                                    formData.append("key","step3_slug");
                                    formData.append("value",itemSlug);
                                    formData.append("item_type",2);
                                    $.ajax({
                                        type: "POST",
                                        url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            if(key == 'pricing-type'){
                                                if(value == 2){
                                                    $('.single-price-project-area').removeClass('d-none')
                                                    $('.pricing-select-first').addClass('d-none')
                                                }else{
                                                    $('.single-price-project-area').addClass('d-none')
                                                }
                                            }
                                        },
                                    });
                                    $('.breadcrumb').find('.breadcrumb-after-item').eq(2).remove()
                                    $('.breadcrumb').append('<span class="breadcrumb-after-item">'+($(this).html())+'</span>')
                                    $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                                    $.ajax({
                                        url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                                        type: "GET", // GET isteği
                                        dataType: "json", // Gelen veri tipi JSON
                                        success: function (data) {
                                            $('.area-list').eq(2).find('li').removeClass('selected');
                                            changeData(data,'housing_type_id');
                                            selectedid = data;
                                            thisx.find('.loading-icon').remove();
                                            if (selectedid) {
                                                $('.rendered-area').removeClass('d-none')
                                            } else {
                                                $.toast({
                                                    heading: 'Hata',
                                                    text: 'Proje Hangi Tipte Konutlardan Oluşuyor Seçeneğini Lütfen Seçiniz',
                                                    position: 'top-right',
                                                    stack: false
                                                })
                                            }
                                            const houseCount = 1;

                                            if (isNaN(houseCount) || houseCount <= 0) {
                                                alert('Lütfen geçerli bir sayı girin.');
                                                return;
                                            }
                                            
                                            $.ajax({
                                                method: "GET",
                                                url: "{{ route('institutional.ht.getform') }}",
                                                data: {
                                                    id: selectedid
                                                },
                                                success: function(response) {
                                                    var html = "";
                                                    var htmlContent = "";
                                                    for (var i = 0; i < houseCount; i++) {

                                                        htmlContent += '<div class="tab-pane fade show ' + (i == 0 ?
                                                                'active' : '') + '" id="TabContent' + (i + 1) +
                                                            '" role="tabpanel">' +
                                                            '<div id="renderForm' + (i + 1) +
                                                            '" class="card p-4"></div>' +
                                                            '</div>';
                                                    }

                                                    $('#tablist').html(html);
                                                    $('.tab-content').html(htmlContent)
                                                    for (let i = 1; i <= houseCount; i++) {
                                                        console.log(i);
                                                        formRenderOpts = {
                                                            dataType: 'json',
                                                            formData: response.form_json
                                                        };

                                                        var renderedForm = $('<div>');
                                                        renderedForm.formRender(formRenderOpts);
                                                        var renderHtml = renderedForm.html().toString();
                                                        renderHtml = renderHtml.toString().split('images[][]');
                                                        var json = JSON.parse(response.form_json);
                                                        renderHtml = renderHtml[0];
                                                        for (var lm = 0; lm < json.length; lm++) {
                                                            if (json[lm].type == "checkbox-group") {
                                                                console.log();
                                                                var renderHtml = renderHtml.toString().split(json[lm]
                                                                    .name + '[]');
                                                                renderHtmlx = "";
                                                                var json = JSON.parse(response.form_json);
                                                                for (var t = 0; t < renderHtml.length; t++) {
                                                                    if (t != renderHtml.length - 1) {
                                                                        renderHtmlx += renderHtml[t] + (json[lm].name
                                                                            .split('[]')[0]) + i + '[][]';
                                                                    } else {
                                                                        renderHtmlx += renderHtml[t];
                                                                    }
                                                                }

                                                                renderHtml = renderHtmlx;
                                                            }

                                                            $('.checkbox-item').closest('.checkbox-group').addClass(
                                                                'd-flex')
                                                            $('.checkbox-item').closest('.checkbox-group').addClass(
                                                                'checkbox-items')
                                                        }

                                                        $('#renderForm' + (i)).html(renderHtml);
                                                        $('#tablist a.nav-link').click(function(e) {
                                                            e.preventDefault(); // Linki tıklamayı engelleyin

                                                            // Tüm sekmeleri gizleyin
                                                            $('.tab-content .tab-pane').removeClass(
                                                                'show active');

                                                            // Tıklanan tab linkine ait tabın kimliğini alın
                                                            var tabId = $(this).attr('data-bs-target');

                                                            // İlgili tabı gösterin
                                                            $(tabId).addClass('show active');
                                                        });
                                                    }

                                                    $('.next_house').click(function() {
                                                        var nextHousing = true;
                                                        $('.tab-pane.active input[required="required"]').map((key, item) => {
                                                            if (!$(item).val()) {
                                                                nextHousing = false;
                                                                $(item).addClass("error-border")
                                                            }
                                                        })

                                                        $('.tab-pane.active select[required="required"]').map((key, item) => {
                                                            if (!$(item).val()) {
                                                                nextHousing = false;
                                                                $(item).addClass("error-border")
                                                            }
                                                        })
                                                        if ($('.tab-pane.active input[required="required"]').val() == "") {
                                                            nextHousing = false;
                                                            $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                                        }
                                                        var indexItem = $('.tab-pane.active').index();
                                                        if (nextHousing) {
                                                            $('.tab-pane.active').removeClass('active');
                                                            $('.tab-pane').eq(indexItem + 1).addClass('active');
                                                        } else {
                                                            $('html, body').animate({
                                                                scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                                                    $('.navbar-top').css('height'))
                                                            }, 100);
                                                        }
                                                    })

                                                    $('.prev_house').click(function() {

                                                        var indexItem = $('.tab-pane.active').index();
                                                        console.log(indexItem);
                                                        $('.tab-pane.active').removeClass('active');
                                                        $('.tab-pane').eq(indexItem - 1).addClass('active');
                                                    })

                                                    $('.second-payment-plan').closest('div').addClass('d-none')
                                                    $('.tab-pane select[multiple="false"]').removeAttr('multiple')

                                                    $('input[value="taksitli"]').change(function() {
                                                        if ($(this).is(':checked')) {
                                                            $('.second-payment-plan').closest('div').removeClass('d-none');
                                                        } else {
                                                            $('.second-payment-plan').closest('div').addClass('d-none');
                                                        }
                                                    })

                                                    

                                                    var csrfToken = "{{ csrf_token() }}";

                                                    $('.add-new-project-house-image').click(function() {
                                                        $(this).parent('div').find('.new_file_on_drop').trigger("click")
                                                    })

                                                    $('.new_project_housing_image').click(function() {
                                                        console.log("asd");
                                                    })

                                                    $('.disabled-housing').closest('.form-group').remove();

                                                    if(isRent){
                                                        $('.rent-disabled').closest('.form-group').remove();
                                                    }

                                                    if(isDailyRent){
                                                        $('.daily-rent-disabled').closest('.form-group').remove();
                                                    }

                                                    if(isSale){
                                                        $('.sale-disabled').closest('.form-group').remove();
                                                        $('.project-disabled').closest('.form-group').remove();
                                                    }

                                                    $('.copy-item').change(function() {
                                                        var order = parseInt($(this).val()) - 1;
                                                        var currentOrder = parseInt($(this).closest('a').attr('data-bs-target')
                                                            .replace('#TabContent', '')) - 1;
                                                        for (var lm = 0; lm < json.length; lm++) {
                                                            if (json[lm].type == "checkbox-group") {
                                                                for (var i = 0; i < json[lm].values.length; i++) {
                                                                    var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                                            '')) + (order + 1) + '[][]"][value="' + json[lm]
                                                                        .values[i].value + '"]' + '').is(':checked')
                                                                    if (isChecked) {
                                                                        $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                                                currentOrder + 1) + '[][]"][value="' + json[lm]
                                                                            .values[i].value + '"]' + '').prop('checked', true)
                                                                    } else {
                                                                        $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                                                currentOrder + 1) + '[][]"][value="' + json[lm]
                                                                            .values[i].value + '"]' + '').prop('checked', false)
                                                                    }
                                                                }
                                                            } else if (json[lm].type == "select") {
                                                                var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                                                    .val();
                                                                $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                                                    .children('option').removeAttr('selected')
                                                                console.log($('select[name="' + (json[lm].name) + '"]').eq(
                                                                    currentOrder).children('option[value="' + value[0] +
                                                                    '"]'));
                                                                $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                                                    .children('option[value="' + value[0] + '"]').prop('selected',
                                                                        true);
                                                            } else if (json[lm].type == "file" && json[lm].name == "image[]") {
                                                                var files = $('input[name="' + (json[lm].name) + '"]').eq(order)[0]
                                                                    .files;
                                                                var input2 = $('input[name="' + (json[lm].name) + '"]').eq(
                                                                    currentOrder);
                                                                for (var i = 0; i < files.length; i++) {
                                                                    var file = files[i];
                                                                    input2.prop("files", files);
                                                                }
                                                            } else if (json[lm].type != "file") {
                                                                var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                                                    .val();
                                                                console.log($('input[name="' + (json[lm].name) + '"]').eq(order)
                                                                    .val());
                                                                $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                                                    value);
                                                            }
                                                        }
                                                    })

                                                    $('.rendered-form input').change(function() {
                                                        console.log("asd");
                                                        var formData = new FormData();
                                                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                                                        formData.append('_token', csrfToken);
                                                        formData.append('value', $(this).val());
                                                        console.log($(this).closest('.tab-pane').attr('id'))
                                                        formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                                            .replace('TabContent', "")) - 1);
                                                        formData.append('key', $(this).attr('name').replace("[]", "").replace("[]",
                                                            ""));
                                                        if($(this).hasClass('only-one')){
                                                            formData.append('only-one',"1");
                                                            $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                                        }
                                                        formData.append('item_type', 2);
                                                        if ($(this).attr('type') == "checkbox") {
                                                            formData.append('checkbox', "1");
                                                        }
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                            data: formData,
                                                            processData: false,
                                                            contentType: false,
                                                            success: function(response) {},
                                                        });
                                                    })

                                                    $('.rendered-form select').change(function() {
                                                        console.log("asd");
                                                        var formData = new FormData();
                                                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                                                        formData.append('_token', csrfToken);
                                                        formData.append('value', $(this).val());
                                                        console.log($(this).closest('.tab-pane').attr('id'))
                                                        formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                                            .replace('TabContent', "")) - 1);
                                                        formData.append('key', $(this).attr('name').replace("[]", ""));
                                                        formData.append('item_type', 2);
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                            data: formData,
                                                            processData: false,
                                                            contentType: false,
                                                            success: function(response) {},
                                                        });
                                                    })

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

                                                    $('.maks-3').keyup(function(){
                                                        console.log("asd")
                                                        if(parseInt($(this).val()) > 3){
                                                            $(this).val(3);
                                                        }
                                                    })

                                                    $('.number-only').keyup(function() {
                                                        $('.number-only .error-text').remove();
                                                        if ($(this).val() != parseInt($(this).val())) {
                                                            if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                                                $(this).val("");
                                                            } else {
                                                                $(this).closest('.form-group').append(
                                                                    '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                                                )
                                                                $(this).val("");
                                                            }

                                                        } else {
                                                            $(this).closest('.form-group').find('.error-text').remove();
                                                        }
                                                    })

                                                    $('.formbuilder-text input').change(function() {
                                                        if ($(this).val() != "") {
                                                            $(this).removeClass('error-border')
                                                        }
                                                    })

                                                    $('.formbuilder-number input').change(function() {
                                                        if ($(this).val() != "") {
                                                            $(this).removeClass('error-border')
                                                        }
                                                    })

                                                    $('.cover-image-by-housing-type').closest('.formbuilder-file').remove();
                                                },
                                                error: function(error) {
                                                    console.log(error)
                                                }
                                            })
                                            thisx.addClass('selected');
                                            $('.area-list').eq(3).addClass('active');
                                        }
                                    })
                                })
                            },
                            error: function (xhr, status, error) {
                                // İstek hata verdiğinde çalışacak fonksiyon
                                console.error(xhr.statusText);
                            }
                        });
                    })

                    
                },
                error: function (xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
        })

        $('.area-list').eq(1).find('li').click(function(){
            itemSlug = $(this).attr('slug');
            if(itemSlug == "kiralik"){
                isRent = true;
            }else{
                isRent = false;
            }
            if(itemSlug == "gunluk-kiralik"){
                isDailyRent = true;
            }else{
                isDailyRent = false;
            }

            if(itemSlug == "satilik"){
                isSale = true;
            }else{
                isSale = false;
            }
            
            var thisx = $(this);
            console.log("asd");
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append("key","step2_slug");
            formData.append("value",itemSlug);
            formData.append("item_type",2);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(key == 'pricing-type'){
                        if(value == 2){
                            $('.single-price-project-area').removeClass('d-none')
                            $('.pricing-select-first').addClass('d-none')
                        }else{
                            $('.single-price-project-area').addClass('d-none')
                        }
                    }
                },
            });
            $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
            $('.breadcrumb').find('.breadcrumb-after-item').eq(1).remove()
            $('.breadcrumb').append('<span class="breadcrumb-after-item">'+($(this).html())+'</span>')
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            $.ajax({
                url: "{{URL::to('/')}}/institutional/get_housing_type_childrens/"+itemSlug+'?parent_slug='+$('.area-list').eq(0).find('li.selected').attr('slug'), // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    console.log(data);
                    $('.area-list').eq(1).find('li').removeClass('selected');
                    data = data.data;
                    var list = "";
                    for(var i = 0 ; i < data.length; i++){
                        list += "<li slug='"+data[i].slug+"'>"+data[i].title+"</li>"
                    }
                    $('.area-list').eq(2).children('ul').html(list)

                    $('.area-list').eq(2).addClass('active');
                    thisx.addClass('selected');
                    thisx.find('.loading-icon').remove();

                    $('.area-list').eq(2).find('li').click(function(){
                        itemSlug = $(this).attr('slug');
                        var thisx = $(this);
                        var formData = new FormData();
                        var csrfToken = $("meta[name='csrf-token']").attr("content");
                        formData.append('_token', csrfToken);
                        formData.append("key","step3_slug");
                        formData.append("value",itemSlug);
                        formData.append("item_type",2);
                        $.ajax({
                            type: "POST",
                            url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if(key == 'pricing-type'){
                                    if(value == 2){
                                        $('.single-price-project-area').removeClass('d-none')
                                        $('.pricing-select-first').addClass('d-none')
                                    }else{
                                        $('.single-price-project-area').addClass('d-none')
                                    }
                                }
                            },
                        });
                        $('.breadcrumb').find('.breadcrumb-after-item').eq(2).remove()
                        $('.breadcrumb').append('<span class="breadcrumb-after-item">'+($(this).html())+'</span>')
                        $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
                        $.ajax({
                            url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                            type: "GET", // GET isteği
                            dataType: "json", // Gelen veri tipi JSON
                            success: function (data) {
                                $('.area-list').eq(2).find('li').removeClass('selected');
                                changeData(data,'housing_type_id');
                                selectedid = data;
                                if (selectedid) {
                                    $('.rendered-area').removeClass('d-none')
                                } else {
                                    $.toast({
                                        heading: 'Hata',
                                        text: 'Proje Hangi Tipte Konutlardan Oluşuyor Seçeneğini Lütfen Seçiniz',
                                        position: 'top-right',
                                        stack: false
                                    })
                                }
                                thisx.find('.loading-icon').remove();
                                const houseCount = 1;

                                if (isNaN(houseCount) || houseCount <= 0) {
                                    alert('Lütfen geçerli bir sayı girin.');
                                    return;
                                }
                                
                                $.ajax({
                                    method: "GET",
                                    url: "{{ route('institutional.ht.getform') }}",
                                    data: {
                                        id: selectedid
                                    },
                                    success: function(response) {
                                        var html = "";
                                        var htmlContent = "";
                                        for (var i = 0; i < houseCount; i++) {

                                            htmlContent += '<div class="tab-pane fade show ' + (i == 0 ?
                                                    'active' : '') + '" id="TabContent' + (i + 1) +
                                                '" role="tabpanel">' +
                                                '<div id="renderForm' + (i + 1) +
                                                '" class="card p-4"></div>' +
                                                '</div>';
                                        }

                                        $('#tablist').html(html);
                                        $('.tab-content').html(htmlContent)
                                        for (let i = 1; i <= houseCount; i++) {
                                            console.log(i);
                                            formRenderOpts = {
                                                dataType: 'json',
                                                formData: response.form_json
                                            };

                                            var renderedForm = $('<div>');
                                            renderedForm.formRender(formRenderOpts);
                                            var renderHtml = renderedForm.html().toString();
                                            renderHtml = renderHtml.toString().split('images[][]');
                                            var json = JSON.parse(response.form_json);
                                            renderHtml = renderHtml[0];
                                            for (var lm = 0; lm < json.length; lm++) {
                                                if (json[lm].type == "checkbox-group") {
                                                    console.log();
                                                    var renderHtml = renderHtml.toString().split(json[lm]
                                                        .name + '[]');
                                                    renderHtmlx = "";
                                                    var json = JSON.parse(response.form_json);
                                                    for (var t = 0; t < renderHtml.length; t++) {
                                                        if (t != renderHtml.length - 1) {
                                                            renderHtmlx += renderHtml[t] + (json[lm].name
                                                                .split('[]')[0]) + i + '[][]';
                                                        } else {
                                                            renderHtmlx += renderHtml[t];
                                                        }
                                                    }

                                                    renderHtml = renderHtmlx;
                                                }

                                                $('.checkbox-item').closest('.checkbox-group').addClass(
                                                    'd-flex')
                                                $('.checkbox-item').closest('.checkbox-group').addClass(
                                                    'checkbox-items')
                                            }

                                            $('#renderForm' + (i)).html(renderHtml);
                                            $('#tablist a.nav-link').click(function(e) {
                                                e.preventDefault(); // Linki tıklamayı engelleyin

                                                // Tüm sekmeleri gizleyin
                                                $('.tab-content .tab-pane').removeClass(
                                                    'show active');

                                                // Tıklanan tab linkine ait tabın kimliğini alın
                                                var tabId = $(this).attr('data-bs-target');

                                                // İlgili tabı gösterin
                                                $(tabId).addClass('show active');
                                            });
                                        }

                                        $('.next_house').click(function() {
                                            var nextHousing = true;
                                            $('.tab-pane.active input[required="required"]').map((key, item) => {
                                                if (!$(item).val()) {
                                                    nextHousing = false;
                                                    $(item).addClass("error-border")
                                                }
                                            })

                                            $('.tab-pane.active select[required="required"]').map((key, item) => {
                                                if (!$(item).val()) {
                                                    nextHousing = false;
                                                    $(item).addClass("error-border")
                                                }
                                            })
                                            if ($('.tab-pane.active input[required="required"]').val() == "") {
                                                nextHousing = false;
                                                $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                            }
                                            var indexItem = $('.tab-pane.active').index();
                                            if (nextHousing) {
                                                $('.tab-pane.active').removeClass('active');
                                                $('.tab-pane').eq(indexItem + 1).addClass('active');
                                            } else {
                                                $('html, body').animate({
                                                    scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                                        $('.navbar-top').css('height'))
                                                }, 100);
                                            }
                                        })

                                        $('.prev_house').click(function() {

                                            var indexItem = $('.tab-pane.active').index();
                                            console.log(indexItem);
                                            $('.tab-pane.active').removeClass('active');
                                            $('.tab-pane').eq(indexItem - 1).addClass('active');
                                        })

                                        $('.second-payment-plan').closest('div').addClass('d-none')
                                        $('.tab-pane select[multiple="false"]').removeAttr('multiple')

                                        $('input[value="taksitli"]').change(function() {
                                            if ($(this).is(':checked')) {
                                                $('.second-payment-plan').closest('div').removeClass('d-none');
                                            } else {
                                                $('.second-payment-plan').closest('div').addClass('d-none');
                                            }
                                        })

                                        

                                        var csrfToken = "{{ csrf_token() }}";

                                        $('.add-new-project-house-image').click(function() {
                                            $(this).parent('div').find('.new_file_on_drop').trigger("click")
                                        })

                                        $('.new_project_housing_image').click(function() {
                                            console.log("asd");
                                        })

                                        $('.disabled-housing').closest('.form-group').remove();
                                        
                                        if(isRent){
                                            $('.rent-disabled').closest('.form-group').remove();
                                        }

                                        if(isDailyRent){
                                            $('.daily-rent-disabled').closest('.form-group').remove();
                                        }

                                        if(isSale){
                                            $('.sale-disabled').closest('.form-group').remove();
                                            $('.project-disabled').closest('.form-group').remove();

                                        }

                                        $('.copy-item').change(function() {
                                            var order = parseInt($(this).val()) - 1;
                                            var currentOrder = parseInt($(this).closest('a').attr('data-bs-target')
                                                .replace('#TabContent', '')) - 1;
                                            for (var lm = 0; lm < json.length; lm++) {
                                                if (json[lm].type == "checkbox-group") {
                                                    for (var i = 0; i < json[lm].values.length; i++) {
                                                        var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                                '')) + (order + 1) + '[][]"][value="' + json[lm]
                                                            .values[i].value + '"]' + '').is(':checked')
                                                        if (isChecked) {
                                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                                .values[i].value + '"]' + '').prop('checked', true)
                                                        } else {
                                                            $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                                    currentOrder + 1) + '[][]"][value="' + json[lm]
                                                                .values[i].value + '"]' + '').prop('checked', false)
                                                        }
                                                    }
                                                } else if (json[lm].type == "select") {
                                                    var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                                        .val();
                                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                                        .children('option').removeAttr('selected')
                                                    console.log($('select[name="' + (json[lm].name) + '"]').eq(
                                                        currentOrder).children('option[value="' + value[0] +
                                                        '"]'));
                                                    $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                                        .children('option[value="' + value[0] + '"]').prop('selected',
                                                            true);
                                                } else if (json[lm].type == "file" && json[lm].name == "image[]") {
                                                    var files = $('input[name="' + (json[lm].name) + '"]').eq(order)[0]
                                                        .files;
                                                    var input2 = $('input[name="' + (json[lm].name) + '"]').eq(
                                                        currentOrder);
                                                    for (var i = 0; i < files.length; i++) {
                                                        var file = files[i];
                                                        input2.prop("files", files);
                                                    }
                                                } else if (json[lm].type != "file") {
                                                    var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                                        .val();
                                                    console.log($('input[name="' + (json[lm].name) + '"]').eq(order)
                                                        .val());
                                                    $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                                        value);
                                                }
                                            }
                                        })

                                        $('.rendered-form input').change(function() {
                                            console.log("asd");
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value', $(this).val());
                                            console.log($(this).closest('.tab-pane').attr('id'))
                                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                                .replace('TabContent', "")) - 1);
                                            formData.append('key', $(this).attr('name').replace("[]", "").replace("[]",
                                                ""));
                                            formData.append('item_type', 2);
                                            if($(this).hasClass('only-one')){
                                                formData.append('only-one',"1");
                                                $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                            }
                                            if ($(this).attr('type') == "checkbox") {
                                                formData.append('checkbox', "1");
                                            }
                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {},
                                            });
                                        })

                                        $('.rendered-form select').change(function() {
                                            console.log("asd");
                                            var formData = new FormData();
                                            var csrfToken = $("meta[name='csrf-token']").attr("content");
                                            formData.append('_token', csrfToken);
                                            formData.append('value', $(this).val());
                                            console.log($(this).closest('.tab-pane').attr('id'))
                                            formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                                .replace('TabContent', "")) - 1);
                                            formData.append('key', $(this).attr('name').replace("[]", ""));
                                            formData.append('item_type', 2);
                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                                data: formData,
                                                processData: false,
                                                contentType: false,
                                                success: function(response) {},
                                            });
                                        })

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

                                        $('.maks-3').keyup(function(){
                                            console.log("asd")
                                            if(parseInt($(this).val()) > 3){
                                                $(this).val(3);
                                            }
                                        })

                                        $('.number-only').keyup(function() {
                                            $('.number-only .error-text').remove();
                                            if ($(this).val() != parseInt($(this).val())) {
                                                if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                                    $(this).val("");
                                                } else {
                                                    $(this).closest('.form-group').append(
                                                        '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                                    )
                                                    $(this).val("");
                                                }

                                            } else {
                                                $(this).closest('.form-group').find('.error-text').remove();
                                            }
                                        })

                                        $('.formbuilder-text input').change(function() {
                                            if ($(this).val() != "") {
                                                $(this).removeClass('error-border')
                                            }
                                        })

                                        $('.formbuilder-number input').change(function() {
                                            if ($(this).val() != "") {
                                                $(this).removeClass('error-border')
                                            }
                                        })

                                        $('.cover-image-by-housing-type').closest('.formbuilder-file').remove();
                                    },
                                    error: function(error) {
                                        console.log(error)
                                    }
                                })
                                thisx.addClass('selected');
                                $('.area-list').eq(3).addClass('active');
                            }
                        })
                    })
                },
                error: function (xhr, status, error) {
                    // İstek hata verdiğinde çalışacak fonksiyon
                    console.error(xhr.statusText);
                }
            });
        })

        $('.area-list').eq(2).find('li').click(function(){
            itemSlug = $(this).attr('slug');
            var thisx = $(this);
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append("key","step3_slug");
            formData.append("value",itemSlug);
            formData.append("item_type",2);
            $.ajax({
                type: "POST",
                url: "{{route('institutional.temp.order.change.area.list.data')}}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(key == 'pricing-type'){
                        if(value == 2){
                            $('.single-price-project-area').removeClass('d-none')
                            $('.pricing-select-first').addClass('d-none')
                        }else{
                            $('.single-price-project-area').addClass('d-none')
                        }
                    }
                },
            });
            $('.breadcrumb').find('.breadcrumb-after-item').eq(2).remove()
            $('.breadcrumb').append('<span class="breadcrumb-after-item">'+($(this).html())+'</span>')
            $(this).append('<div class="loading-icon"><i class="fa fa-spinner"></i></div>')
            $.ajax({
                url: "{{URL::to('/')}}/institutional/get_housing_type_id/"+itemSlug, // AJAX isteği yapılacak URL
                type: "GET", // GET isteği
                dataType: "json", // Gelen veri tipi JSON
                success: function (data) {
                    $('.area-list').eq(2).find('li').removeClass('selected');
                    changeData(data,'housing_type_id');
                    selectedid = data;
                    
                    if (selectedid) {
                        $('.rendered-area').removeClass('d-none')
                    } else {
                        $.toast({
                            heading: 'Hata',
                            text: 'Proje Hangi Tipte Konutlardan Oluşuyor Seçeneğini Lütfen Seçiniz',
                            position: 'top-right',
                            stack: false
                        })
                    }
                    const houseCount = 1;
                    thisx.find('.loading-icon').remove();

                    if (isNaN(houseCount) || houseCount <= 0) {
                        alert('Lütfen geçerli bir sayı girin.');
                        return;
                    }

                    $.ajax({
                        method: "GET",
                        url: "{{ route('institutional.ht.getform') }}",
                        data: {
                            id: selectedid
                        },
                        success: function(response) {
                            var html = "";
                            var htmlContent = "";
                            for (var i = 0; i < houseCount; i++) {

                                htmlContent += '<div class="tab-pane fade show ' + (i == 0 ?
                                        'active' : '') + '" id="TabContent' + (i + 1) +
                                    '" role="tabpanel">' +
                                    '<div id="renderForm' + (i + 1) +
                                    '" class="card p-4"></div>' +
                                    '</div>';
                            }

                            $('#tablist').html(html);
                            $('.tab-content').html(htmlContent)
                            for (let i = 1; i <= houseCount; i++) {
                                console.log(i);
                                formRenderOpts = {
                                    dataType: 'json',
                                    formData: response.form_json
                                };

                                var renderedForm = $('<div>');
                                renderedForm.formRender(formRenderOpts);
                                var renderHtml = renderedForm.html().toString();
                                renderHtml = renderHtml.toString().split('images[][]');
                                var json = JSON.parse(response.form_json);
                                renderHtml = renderHtml[0];
                                for (var lm = 0; lm < json.length; lm++) {
                                    if (json[lm].type == "checkbox-group") {
                                        console.log();
                                        var renderHtml = renderHtml.toString().split(json[lm]
                                            .name + '[]');
                                        renderHtmlx = "";
                                        var json = JSON.parse(response.form_json);
                                        for (var t = 0; t < renderHtml.length; t++) {
                                            if (t != renderHtml.length - 1) {
                                                renderHtmlx += renderHtml[t] + (json[lm].name
                                                    .split('[]')[0]) + i + '[][]';
                                            } else {
                                                renderHtmlx += renderHtml[t];
                                            }
                                        }

                                        renderHtml = renderHtmlx;
                                    }

                                    $('.checkbox-item').closest('.checkbox-group').addClass(
                                        'd-flex')
                                    $('.checkbox-item').closest('.checkbox-group').addClass(
                                        'checkbox-items')
                                }

                                $('#renderForm' + (i)).html(renderHtml);
                                $('#tablist a.nav-link').click(function(e) {
                                    e.preventDefault(); // Linki tıklamayı engelleyin

                                    // Tüm sekmeleri gizleyin
                                    $('.tab-content .tab-pane').removeClass(
                                        'show active');

                                    // Tıklanan tab linkine ait tabın kimliğini alın
                                    var tabId = $(this).attr('data-bs-target');

                                    // İlgili tabı gösterin
                                    $(tabId).addClass('show active');
                                });
                            }

                            $('.next_house').click(function() {
                                var nextHousing = true;
                                $('.tab-pane.active input[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })

                                $('.tab-pane.active select[required="required"]').map((key, item) => {
                                    if (!$(item).val()) {
                                        nextHousing = false;
                                        $(item).addClass("error-border")
                                    }
                                })
                                if ($('.tab-pane.active input[required="required"]').val() == "") {
                                    nextHousing = false;
                                    $('.tab-pane.active input[name="price[]"]').addClass('error-border')
                                }
                                var indexItem = $('.tab-pane.active').index();
                                if (nextHousing) {
                                    $('.tab-pane.active').removeClass('active');
                                    $('.tab-pane').eq(indexItem + 1).addClass('active');
                                } else {
                                    $('html, body').animate({
                                        scrollTop: $('.tab-pane.active').offset().top - parseFloat(
                                            $('.navbar-top').css('height'))
                                    }, 100);
                                }
                            })

                            $('.prev_house').click(function() {

                                var indexItem = $('.tab-pane.active').index();
                                console.log(indexItem);
                                $('.tab-pane.active').removeClass('active');
                                $('.tab-pane').eq(indexItem - 1).addClass('active');
                            })

                            $('.second-payment-plan').closest('div').addClass('d-none')
                            $('.tab-pane select[multiple="false"]').removeAttr('multiple')

                            $('input[value="taksitli"]').change(function() {
                                if ($(this).is(':checked')) {
                                    $('.second-payment-plan').closest('div').removeClass('d-none');
                                } else {
                                    $('.second-payment-plan').closest('div').addClass('d-none');
                                }
                            })

                            

                            var csrfToken = "{{ csrf_token() }}";

                            $('.add-new-project-house-image').click(function() {
                                $(this).parent('div').find('.new_file_on_drop').trigger("click")
                            })

                            $('.new_project_housing_image').click(function() {
                                console.log("asd");
                            })

                            $('.disabled-housing').closest('.form-group').remove();
                            if(isRent){
                                $('.rent-disabled').closest('.form-group').remove();
                            }

                            if(isDailyRent){
                                $('.daily-rent-disabled').closest('.form-group').remove();
                            }
                             
                            if(isSale){
                                $('.sale-disabled').closest('.form-group').remove();
                                $('.project-disabled').closest('.form-group').remove();
                            }

                            $('.copy-item').change(function() {
                                var order = parseInt($(this).val()) - 1;
                                var currentOrder = parseInt($(this).closest('a').attr('data-bs-target')
                                    .replace('#TabContent', '')) - 1;
                                for (var lm = 0; lm < json.length; lm++) {
                                    if (json[lm].type == "checkbox-group") {
                                        for (var i = 0; i < json[lm].values.length; i++) {
                                            var isChecked = $('input[name="' + (json[lm].name.replace('[]',
                                                    '')) + (order + 1) + '[][]"][value="' + json[lm]
                                                .values[i].value + '"]' + '').is(':checked')
                                            if (isChecked) {
                                                $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                        currentOrder + 1) + '[][]"][value="' + json[lm]
                                                    .values[i].value + '"]' + '').prop('checked', true)
                                            } else {
                                                $('input[name="' + (json[lm].name.replace('[]', '')) + (
                                                        currentOrder + 1) + '[][]"][value="' + json[lm]
                                                    .values[i].value + '"]' + '').prop('checked', false)
                                            }
                                        }
                                    } else if (json[lm].type == "select") {
                                        var value = $('select[name="' + (json[lm].name) + '"]').eq(order)
                                            .val();
                                        $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                            .children('option').removeAttr('selected')
                                        console.log($('select[name="' + (json[lm].name) + '"]').eq(
                                            currentOrder).children('option[value="' + value[0] +
                                            '"]'));
                                        $('select[name="' + (json[lm].name) + '"]').eq(currentOrder)
                                            .children('option[value="' + value[0] + '"]').prop('selected',
                                                true);
                                    } else if (json[lm].type == "file" && json[lm].name == "image[]") {
                                        var files = $('input[name="' + (json[lm].name) + '"]').eq(order)[0]
                                            .files;
                                        var input2 = $('input[name="' + (json[lm].name) + '"]').eq(
                                            currentOrder);
                                        for (var i = 0; i < files.length; i++) {
                                            var file = files[i];
                                            input2.prop("files", files);
                                        }
                                    } else if (json[lm].type != "file") {
                                        var value = $('input[name="' + (json[lm].name) + '"]').eq(order)
                                            .val();
                                        console.log($('input[name="' + (json[lm].name) + '"]').eq(order)
                                            .val());
                                        $('input[name="' + (json[lm].name) + '"]').eq(currentOrder).val(
                                            value);
                                    }
                                }
                            })

                            $('.rendered-form input').change(function() {
                                console.log("asd");
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value', $(this).val());
                                console.log($(this).closest('.tab-pane').attr('id'))
                                formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                    .replace('TabContent', "")) - 1);
                                formData.append('key', $(this).attr('name').replace("[]", "").replace("[]",
                                    ""));
                                if($(this).hasClass('only-one')){
                                    formData.append('only-one',"1");
                                    $(this).closest('.form-group').find('.only-one[value!="'+$(this).val()+'"]').prop('checked',false);
                                }
                                formData.append('item_type', 2);
                                if ($(this).attr('type') == "checkbox") {
                                    formData.append('checkbox', "1");
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {},
                                });
                            })

                            $('.rendered-form select').change(function() {
                                console.log("asd");
                                var formData = new FormData();
                                var csrfToken = $("meta[name='csrf-token']").attr("content");
                                formData.append('_token', csrfToken);
                                formData.append('value', $(this).val());
                                console.log($(this).closest('.tab-pane').attr('id'))
                                formData.append('order', parseInt($(this).closest('.tab-pane').attr('id')
                                    .replace('TabContent', "")) - 1);
                                formData.append('key', $(this).attr('name').replace("[]", ""));
                                formData.append('item_type', 2);
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('institutional.temp.order.project.housing.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {},
                                });
                            })

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

                            $('.maks-3').keyup(function(){
                                console.log("asd")
                                if(parseInt($(this).val()) > 3){
                                    $(this).val(3);
                                }
                            })

                            $('.number-only').keyup(function() {
                                $('.number-only .error-text').remove();
                                if ($(this).val() != parseInt($(this).val())) {
                                    if ($(this).closest('.form-group').find('.error-text').length > 0) {
                                        $(this).val("");
                                    } else {
                                        $(this).closest('.form-group').append(
                                            '<span class="error-text">Girilen değer sadece sayı olmalıdır</span>'
                                        )
                                        $(this).val("");
                                    }

                                } else {
                                    $(this).closest('.form-group').find('.error-text').remove();
                                }
                            })

                            $('.formbuilder-text input').change(function() {
                                if ($(this).val() != "") {
                                    $(this).removeClass('error-border')
                                }
                            })

                            $('.formbuilder-number input').change(function() {
                                if ($(this).val() != "") {
                                    $(this).removeClass('error-border')
                                }
                            })

                            $('.cover-image-by-housing-type').closest('.formbuilder-file').remove();
                            thisx.addClass('selected');
                            $('.area-list').eq(3).addClass('active');
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    })
                
                    $('.area-list').eq(3).addClass('active');
                }
            })
        })
    </script>
    <script>
        var $select = $('#housing_status').selectize();
        var selectize = $select[0].selectize;
        selectize.on('item_click', function(item) {
            console.log("asd");
            selectize.removeItem(item);
        });



        $('#housing_status').change(function() {
            var value = $(this).val();
            var html = "<option value=''>Statü Seç</option>";
            for (var i = 0; i < value.length; i++) {
                html += "<option value='" + value[i] + "'>" + ($('#housing_status option[value="' + value[i] + '"]')
                    .html()) + "</option>";
            }
            $('.doping_statuses').html(html);
            var key = "statuses";
            var isArray = 1;
            var formData = new FormData();
            var csrfToken = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', csrfToken);
            formData.append('value', value);
            formData.append('key', key);
            formData.append('item_type', 2);
            formData.append('array_data', isArray);
            $.ajax({
                type: "POST",
                url: "{{ route('institutional.temp.order.data.change') }}", // Sunucunuzun dosya yükleme işlemini karşılayan URL'sini buraya ekleyin
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {},
            });
        })

        changeData($('#location').val(), "location")
    </script>
    @stack('scripts')
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css"
        integrity="sha512-8D+M+7Y6jVsEa7RD6Kv/Z7EImSpNpQllgaEIQAtqHcI0H6F4iZknRj0Nx1DCdB+TwBaS+702BGWYC0Ze2hpExQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/vendors/choices/selectize.css" />
    <link rel="stylesheet" href="{{ URL::to('/') }}/adminassets/assets/css/daterangepicker.css">
    <link rel="stylesheet" href="{{URL::to('/')}}/adminassets/rich-editor/richtext.min.css">
@endsection
