@extends('client.layouts.master')

@section('content')
    @if (Auth::check() && Auth::user()->has_club == 0)
        <section class="how-it-works-two bg-white rec-pro">
            <div class="container">
                <div class="card-header p-4 border-bottom ">
                    <strong class="me-auto" style="font-size: 13px">Emlak Sepette | Emlak Kulüp Başvurusu</strong>
                </div>
                <div class="toast-body "> 
                    <strong style="font-weight: 700;color:black;font-size:13px">Emlak Kulüp ayrıcalıklarından faydalanmak için lütfen aşağıdaki bilgileri
                        eksiksiz doldurun ve
                        üyelik
                        sözleşmesini onaylayın.</strong>
                    <form action="{{ route('institutional.club.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Diğer giriş alanlarını buraya ekleyin -->
                        <div class="corporate-form" id="corporateForm">

                            {{-- <div class="mt-3">
                <label class="q-label">İsim</label>
                <input type="text" name="name" disabled readonly
                    class="form-control @error('name') is-invalid @enderror"value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> --}}
                            <div class="mt-3">
                                <label class="form-label">Telefon</label>
                                <input type="number" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}" id="phone" maxlength="10">
                                    <span id="error_message" class="error-message"></span>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if (Auth::check() && Auth::user()->type == '1')
                                <div class="mt-3">
                                    <label class="form-label">Tc Kimlik No</label>
                                    <input type="number" name="idNumber"
                                        class="form-control @error('idNumber') is-invalid @enderror"
                                        value="{{ old('idNumber', $user->idNumber) }}">
                                    @error('idNumber')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            <div class="mt-3">
                                <label class="form-label">Hesap Sahibinin Adı Soyadı</label>
                                <input type="text" name="bank_name"
                                    class="form-control @error('bank_name') is-invalid @enderror"
                                    value="{{ old('bank_name', $user->bank_name) }}">
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <label class="form-label">Iban Numarası
                                    <i class="fa fa-info-circle ml-2"  data-toggle="tooltip" style="font-size: 12px;"
                                        aria-label="Lütfen geçerli bir iban giriniz. Koleksiyonlarınızdan satış yapıldığında kazandığınız miktar emlaksepette.com tarafından sizlere gönderilir."
                                        title="Lütfen geçerli bir iban giriniz. Koleksiyonlarınızdan satış yapıldığında kazandığınız miktar emlaksepette.com tarafından sizlere gönderilir."></i></label>
                                        <input type="text" name="iban" id="ibanInput"
                                        class="form-control @error('iban') is-invalid @enderror"
                                        value="{{ old('iban', $user->iban) }}" oninput="formatIBAN(this)">
                                    @error('iban')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>



                        </div>
                        <div class="filter-tags-wrap  mt-3" id="corporateFormCheck">
                            <input id="check-d" class="@error('check-d') is-invalid @enderror mr-2" type="checkbox"
                                name="check-d">
                            <label for="check-d" style="font-size: 11px !important;margin-bottom: 0 !important">
                                <a href="/sayfa/emlak-kulup-uyelik-sozlesmesi" target="_blank">
                                    Emlak Kulüp üyelik sözleşmesini
                                </a>
                                okudum onaylıyorum.
                            </label>

                            <br>
                        </div>
                        @error('check-d')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <button type="submit" class="btn btn-primary mt-5">Üye Ol </button>
                    </form>
                </div>
            </div>
        </section>
       
    @endif

    <section class="recently portfolio bg-white homepage-5 mt-5 emlak-kulup-slider recently2">
        <div class="container recently-slider">
            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider" style="height: 550px">
                    <a href="javascript:void()" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                        <div class="recent-img16 sliderSize img-fluid img-center mobile-hidden"
                            style="background-image: url(images/emlakKulupGorsel.png)"></div>
                        <div class="recent-img16 sliderSize img-fluid img-center mobile-show heitwo heithree"
                            style="background-image: url(images/bannerNew_mobil.png);"></div>

                    </a>
                </div>
            </div>
        </div>
    </section>


    <section class="how-it-works-two bg-white rec-pro">
        <div class="container">
            <div class="row service-1">
                <article class="col-lg-12 col-md-12 col-xs-12 serv aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="150">
                    <div class="row align-items-center justify-content-center hw50">
                        <div class="col-md-1 col-12" style="padding: 0;height:100%">
                            <div class="art-1 img-13 mobile-icon"
                                style="background-color: #ea2a28;height:100%; color: white;">
                                <img src="{{ asset('/contact.png') }}" alt="" class="mobile-hidden"
                                    style="height:38px;width:38px;display:flex;align-items:center" />
                                <img src="{{ asset('/contact-black.png') }}" alt="" class="mobile-show"
                                    style="height:38px;width:38px;display:flex;align-items:center" />
                            </div>
                        </div>
                        <div class="col-md-11 col-12" style="padding:0;height:100%">
                            <div class="service-text-p mobile-text"
                                style="background-color: black; color: white;height:100%">
                                <p class="text-center">
                                    <a href="{{url('/')}}" class="linkColor mr-2" style="color: #ea2a28;" >Emlaksepette.com </a> üzerinden Emlak Kulübe üye ol.
                                </p>
                            </div>
                        </div>


                    </div>
                </article>
            </div>
            <div class="row service-1 mt-5">
                <article class="col-lg-12 col-md-12 col-xs-12 serv aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="150">
                    <div class="row align-items-center justify-content-center hw50">
                        <div class="col-md-1 col-12" style="padding: 0;height:100%">
                            <div class="art-1 img-13 mobile-icon"
                                style="background-color: #ea2a28;height:100%; color: white;">
                                <img src="{{ asset('/share.png') }}" alt="" class="mobile-hidden"
                                    style="height:38px;width:38px;display:flex;align-items:center" />
                                <img src="{{ asset('/share.png') }}" alt="" class="mobile-show"
                                    style="height:38px;width:38px;display:flex;align-items:center" />
                            </div>
                        </div>
                        <div class="col-md-11 col-12" style="padding:0;height:100%">
                            <div class="service-text-p mobile-text"
                                style="background-color: black; color: white;height:100%">
                                <p class="text-center">İstediğin kadar ilanı  koleksiyonuna ekleyip sana özel oluşturulan link ile kendi sosyal medya hesaplarından paylaş. </p>
                            </div>
                        </div>


                    </div>
                </article>
            </div>
            <div class="row service-1 mt-5">
                <article class="col-lg-12 col-md-12 col-xs-12 serv aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="150">
                    <div class="row align-items-center justify-content-center hw50">
                        <div class="col-md-1 col-12" style="padding: 0;height:100%">
                            <div class="art-1 img-13 mobile-icon"
                                style="background-color: #ea2a28;height:100%; color: white;">
                                <img src="{{ asset('/contact3.png') }}" alt=""
                                    style="height:38px;width:38px;display:flex;align-items:center" />
                            </div>
                        </div>
                        <div class="col-md-11 col-12" style="padding:0;height:100%">
                            <div class="service-text-p mobile-text"
                                style="background-color: black; color: white;height:100%">
                                <p class="text-center">
                                    Böylece paylaştığın ve satışla sonuçlanan her ilan için bizimle beraber sende kazanırsın.
                                </p>
                            </div>
                        </div>


                    </div>
                </article>
            </div>
        </div>
    </section>



    <section class="faq service-details bg-white">
        <div class="container">
            <h2 class="mb-3" style="font-size: 15px">Sıkça Sorulan Sorular
            </h2>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <ul class="accordion accordion-1 one-open">
                        <li class="active">
                            <div class="title">
                                <span>Emlaksepette.com Paylaş Kazan Nedir?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-down"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com Paylaştıkça Kazan kampanyası, istediğin ilanları koleksiyonuna
                                    ekleyerek sana özel link ile farklı pek çok mecrada
                                    paylaşmanı ve bu yolla kazanç elde etmeni sağlayan Türkiye’nin en büyük ve en çok
                                    kazandıran paylaş kazan uygulamasıdır.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>En fazla ne kadar kazanç elde edebilirim?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com Paylaştıkça Kazan kampanyası ile koleksiyonuna eklemiş olduğun
                                    ilanların sana özel linkleri paylaşarak
                                    satışına aracılık yapman durumunda aylık 500 bin tl kazanç elde edebilirsin. </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Kazanç komisyonu neye göre belirlenir?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com’ da bulunan proje ilanlarını koleksiyonuna ekleyerek paylaşım yaptığın
                                    ilanların satılması durumunda
                                    toplam fiyat üzerinden %1 komisyon kazanırsınız. (Örneğin X İnşaat firmasının
                                    projesindeki bir dairenin fiyatı 10 milyon TL
                                    paylaşmış olduğun link üzerinde satılması karşılığında emlak sepette.com emlak kulübü
                                    üyesine vergiler düşülerek net
                                    78 bin tl nakit ödeme yapar)
                                    Emlaksepette.com’ da bulunan emlak ilanlarını koleksiyonuna ekleyerek paylaşım yaptığın
                                    ilanların satılması durumunda
                                    toplam fiyat üzerinden %0.5 komisyon kazanırsınız </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">

                                <span>Koleksiyona ilan eklemede ve paylaşımda sınır var mı?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>
                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com Paylaştıkça Kazan'da ilan paylaşımında sınır yok istediğin kadar ilanı
                                    koleksiyonuna ekleyerek paylaş.
                                    Paylaşılan ilan sayısı arttıkça kazanma şansın da artar.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Hangi ilanlarda komisyon kazanabilirim?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Emlak kulüp üyeleri Paylaştıkça Kazan kampanyasına göre emlaksepete.com üzerindeki tüm
                                    kategorilerdeki emlak ilanlarını
                                    paylaşabilir, linkinden satın alım yapıldığı zaman komisyon kazanabilirsin.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Paylaştığım linkten gelen kişiler kaç gün içinde satın alma yaparsa benim kazancıma

                                    yansır?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>
                            </div>
                            <div class="content">
                                <p>
                                    Oluşturulan paylaştıkça kazan linki üzerinden emlaksepette.com ‘a gelen kullanıcının 24
                                    gün boyunca sistem de link
                                    üzerinden geldiği tanınır. 24 gün içinde link paylaşımınızdan satış olması durumunda
                                    kazancınıza yansır </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Koleksiyonuma eklediğim ilanların linkini paylaşımından sonra fiyat değişikliği olursa
                                    ne olur?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com üzerinde bulunan kurumsal mağazalar fiyatı artırması veya düşürmesi
                                    durumunda en son güncel
                                    fiyat üzerinden komisyon kazanırsınız. </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Komisyonumu ne zaman alabilirim?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Onaylanan komisyonunuzu, bize belirttiğin hesap bilgilerine ya da kestiğin faturaya
                                    istinaden her ayın 15 ile 20’si aralığında
                                    yatırıyoruz. Ör. Kasım ayı kazancını (yasal) iptal iade süreci sebebiyle Aralık ayı
                                    sonunda tamamlıyoruz, bu doğrultuda
                                    Kasım ayı ödemeni en geç Ocak ayının 20‘sine kadar alıyorsunuz.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Komisyon kazancımı ne şekilde alabilirim?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com Paylaştıkça Kazan kampanyasından elde ettiğin kazancını alabilmen için
                                    ödeme bilgilerini eksiksiz ve
                                    doğrubir şekilde girmiş olman gerekiyor. Ödeme bilgilerin tamamlanmışsa üyelikte bizlere
                                    ilettiğin IBAN- hesap numarasına
                                    kazancın nakit olarak iletilecektir. Emlaksepette.com şahıs ödemeleri kapsamında ilgili
                                    kullanıcıların adına gider pusulası
                                    düzenleyip, oluşan stopaj maliyetinin ödemesini de kendi tarafında üstlenecektir fakat
                                    gelir beyanının yapılması, ödemeyi
                                    alan kullanıcının kendi sorumluluğunda olup oluşabilecek her türlü vergi ve
                                    yükümlülükler sizlerin sorumluluğundadır </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Paylaştığım ilan iptal ya da iade edildi ise kazancım iptal olur mu?


                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>
                            </div>
                            <div class="content">
                                <p>
                                    Evet, iptal veya iade edilen ilanlarda kazanç sağlayamazsın. Bir ay içerisinde
                                    paylaştığın ürünlerden gelen siparişler
                                    iptal ve iade süresi dolduktan sonra kontrol edilip kesinleşmiş satışlar üzerinden
                                    kazancın hesaplanır.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Kendi linkim üzerinden satın alım yaparak kazanç elde edebilir miyim?



                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>
                            </div>
                            <div class="content">
                                <p>
                                    Paylaştıkça kazan kampanyasında emlak kulüp üyeleri kendilerine ait linki paylaşarak
                                    kendi linklerinden komisyon kazanırlar.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>Aydınlatma metnini onaylamadan katılabilir miyim?


                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>
                            </div>
                            <div class="content">
                                <p>
                                    Emlaksepette.com Paylaştıkça Kazan'da gelir elde edebilmek için aydınlatma metnine ve
                                    taahütnameye onay vermelisin.
                                    Aydınlatma metninin onaylanmadığı durumlarda paylaşım yapılsa da kazanç elde edilemez.
                                </p>
                            </div>
                        </li>
                    </ul>
                    <!--end of accordion-->
                </div>
            </div>
        </div>
    </section>


    <section class="recently content-section-type-1 portfolio bg-white homepage-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 black-section">
                    <div class="inner-wrapper">
                        <div class="content-wrapper">
                            <div class="columns-wrapper">
                                <div class="column column-100 icon-box-type-5 wow fadeInUp" data-wow-duration="0.5s"
                                    data-wow-delay="0.2s"
                                    style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.2s; animation-name: fadeInUp;">
                                    <div class="inner-service">
                                        <span class="icon-wrapper">
                                            <i class="fa fa-home"></i>
                                        </span>
                                        <div class="content-wrapper">
                                            <h6 class="title">Emlak Kulüp Nedir ?</h6>
                                            <p class="content">Emlak Kulüp, en sevdiğin Emlak Sepette ürünlerini,
                                                arkadaşlarınla, ailenle veya takipçilerinle paylaştığın, paylaştıkça
                                                kazandığın bir Affiliate / Satış Ortaklığı Platformu’dur.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="column column-100 icon-box-type-5 wow fadeInUp" data-wow-duration="0.5s"
                                    data-wow-delay="0.3s"
                                    style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.3s; animation-name: fadeInUp;">
                                    <div class="inner-service">
                                        <span class="icon-wrapper">
                                            <i class="fa fa-share-alt"></i>
                                        </span>
                                        <div class="content-wrapper">
                                            <h6 class="title">Peki, Paylaşmak nasıl mı kazandırıyor ? </h6>
                                            <p class="content">Emlak Sepette'den seçtiğin, beğendiğin emlak veya proje
                                                konutlarını, kendi sosyal medya hesaplarında sana özel oluşturduğumuz
                                                linki ekleyerek paylaşıyorsun. Paylaştığın link üzerinden Emlak
                                                Sepette'den yapılan her alışveriş ise sana nakit kazanç sağlıyor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 rigthSide gradient-overlay background-image"
                    style="background-image: url('club/assets/img/content-sections/content-image-2.jpg')">
                    <div class="right-side-inner">
                        <h2 class="background-title">
                            Emlaksepette.com ‘da yer alan yüzbinlerce proje ilanını ve emlak ilanlarını seç ve bütün dünya
                            ile paylaş. <br><br>
                            Aylık 50.000
                            TL ile 500.000 tl arasında linklerinden nakit gelir elde etme hakkı kazan! <br><br> Emlak kulüp
                            üyeleri arasından en başarılı ilk yüz
                            kişiye süpriz hediyeler! </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="how-it-works bg-white rec-pro">
        <div class="container">
            <div class="row service-1">
                <article class="col-lg-3 col-md-6 col-xs-12 serv aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="150">
                    <div class="serv-flex">
                        <div class="art-1 img-13">
                            <i class="fa fa-share-alt"></i>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">Paylaşımlarını yaptığın sosyal medya hesaplarını herkese görünür
                                yaparsan
                                daha fazla kişiye ulaşırsın

                            </p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-3 col-md-6 col-xs-12 serv aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="250">
                    <div class="serv-flex">
                        <div class="art-1 img-14">
                            <i class="fa fa-tag"></i>

                        </div>
                        <div class="service-text-p">
                            <p class="text-center">#işbirliği #affiliate #işortaklığı #affiliatelink hashtag 'lerini
                                kullanmayı unutma!</p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-3 col-md-6 col-xs-12 serv mb-0 pt aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="350">
                    <div class="serv-flex arrow">
                        <div class="art-1 img-15">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="service-text-p">
                            <p class="text-center">Sosyal medya hesaplarının ne kadar popüler olduğu fark etmeksizin
                                paylaşımlarında hepsini değerlendir, satış nereden gelir bilinmez!

                            </p>
                        </div>
                    </div>
                </article>
                <article class="col-lg-3 col-md-6 col-xs-12 serv mb-0 pt its-2 aos-init aos-animate" data-aos="fade-up"
                    data-aos-delay="450">
                    <div class="serv-flex">
                        <div class="art-1 img-14">
                            <i class="fa fa-home"></i>

                        </div>
                        <div class="service-text-p">
                            <p class="text-center">Takipçilerine ilham ver! Doğru evi bulmalarına aracı oll

                            </p>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $("#phone").on("input blur", function(){
        var phoneNumber = $(this).val();
        var pattern = /^5[1-9]\d{8}$/;
    
        if (!pattern.test(phoneNumber)) {
          $("#error_message").text("Lütfen geçerli bir telefon numarası giriniz.");
        } else {
          $("#error_message").text("");
        }
             // Kullanıcı 10 haneden fazla veri girdiğinde bu kontrol edilir
             $('#phone').on('keypress', function (e) {
                        var max_length = 10;
                        // Eğer giriş karakter sayısı 10'a ulaştıysa ve yeni karakter ekleme işlemi değilse
                        if ($(this).val().length >= max_length && e.which != 8 && e.which != 0) {
                            // Olayın işlenmesini durdur
                            e.preventDefault();
                        }
                    });
      });
    });
    </script>
    <script>
        $(".accordion li").click(function() {
            $(".faq li").not(this).removeClass("active");
            $(".faq li i").not($(this).find("i")).removeClass("fa-chevron-down").addClass("fa-chevron-right");
            $(this).toggleClass("active").find("i").toggleClass("fa-chevron-right", !$(this).hasClass("active"))
                .toggleClass("fa-chevron-down", $(this).hasClass("active"));

        });
    </script>

<script>
    function formatIBAN(input) {
        // TR ile başlat
        var formattedIBAN = "TR";

        // Gelen değerden sadece rakamları al
        var numbersOnly = input.value.replace(/\D/g, '');

        // İBAN uzunluğunu kontrol et ve fazla karakterleri kırp
        if (numbersOnly.length > 24) {
            numbersOnly = numbersOnly.substring(0, 24);
        }

        // Geri kalanı 4'er basamaklı gruplara ayır ve aralarına boşluk ekle
        for (var i = 0; i < numbersOnly.length; i += 4) {
            formattedIBAN += numbersOnly.substr(i, 4) + " ";
        }

        // Formatlanmış İBAN'ı input değerine ata
        input.value = formattedIBAN.trim();
    }

    // Giriş alanının değeri değiştiğinde formatIBAN fonksiyonunu çağır
    document.getElementById("ibanInput").addEventListener("input", function() {
        formatIBAN(this);
    });
</script>




@endsection

@section('styles')
    <style>
                .error-message {
            color: red;
            font-size: 11px;
        }
        .how-it-works{
            padding: 2.6rem 0 2.6rem 2.6rem !important;
        }
        .linkColor{
            color: #ea2a28 !important;
        }
        .recently2{
            padding: 0 !important;
        }
        .how-it-works-two {
            padding: 2.6rem 0;
        }

        .home5-right-slider,
        .home5-right-slider .owl-stage-outer,
        .recent-16 {
            height: 550px !important;
        }


        .hw50 {
            height: 50px !important
        }

        .how-it-works-two .service-1 {
            width: 100%;
            margin: 0 auto
        }

        .how-it-works-two .service-1 .art-1 {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto
        }


        .how-it-works-two .service-1 p {
            margin: 0;
            height: 100%;
            align-items: center;
            color: white;
            display: flex;
            justify-content: center;
            font-size: 15px;
            padding: 5px 75px;
            line-height: 1.5rem;
        }


        @media (max-width: 768px) {

            .emlak-kulup-slider .home5-right-slider,
            .emlak-kulup-slider .home5-right-slider .owl-stage-outer,
            .emlak-kulup-slider .recent-16 {
                height: 250px !important;
            }

            .emlak-kulup-slider {
                margin-bottom: 0 !important;
                padding-bottom: 0 !important;

            }

            .emlak-kulup-slider .recently-slider {
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

            .how-it-works-two .service-1 p {
                padding: 5px
            }

            .home5-right-slider,
            .recent-16,
            .home5-right-slider,
            .home5-right-slider .owl-stage-outer,
            .recent-16 {
                height: 200px !important;
            }

            .how-it-works-two p {
                font-size: 11px !important;
                line-height: 23px;
                padding: 5px;
            }

            .hw50 {
                height: auto !important
            }

        }

        #corporateFormCheck {
            display: flex;
            align-items: center;
        }
    </style>
@endsection
