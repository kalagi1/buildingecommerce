@extends('client.layouts.master')

@section('content')
    <section class="recently portfolio bg-white homepage-5">
        <div class="container recently-slider">
            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    <a href="javascript:void()" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                        <div class="recent-img16 sliderSize img-fluid img-center mobile-hidden"
                            style="background-image: url(images/emlakkulupslider.jpeg)"></div>
                        <div class="recent-img16 sliderSize img-fluid img-center mobile-show heitwo"
                            style="background-image: url(images/emlakkulupslider.jpeg);"></div>

                    </a>
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
                            <p class="text-center">Paylaşımlarını yaptığın sosyal medya hesaplarını herkese görünür yaparsan
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
                                <div class="column column-100 icon-box-type-5 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.2s" style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.2s; animation-name: fadeInUp;">
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
                                <div class="column column-100 icon-box-type-5 wow fadeInUp" data-wow-duration="0.5s" data-wow-delay="0.3s" style="visibility: visible; animation-duration: 0.5s; animation-delay: 0.3s; animation-name: fadeInUp;">
                                    <div class="inner-service">
                                        <span class="icon-wrapper">
                                            <i class="fa fa-share-alt"></i>
                                        </span>
                                        <div class="content-wrapper">
                                            <h6 class="title">Peki, Paylaşmak nasıl mı kazandırıyor ? </h6>
                                            <p class="content">Emlak Sepette'den seçtiğin, beğendiğin emlak veya proje
                                                konutlarını, kendi sosyal medya hesaplannda sana özel oluşturduğumuz
                                                linki ekleyerek paylaşıyorsun. Paylaştığın link üzerinden Emlak
                                                Sepette'den yapılan her alışveriş ise sana nakit kazanç sağlıyor</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 rigthSide gradient-overlay background-image"  style="background-image: url('club/assets/img/content-sections/content-image-2.jpg')">
                    <div class="right-side-inner">
                        <h2 class="background-title">
                            Emlaksepette.com ‘da yer alan yüzbinlerce proje ilanını ve emlak ilanlarını seç ve bütün dünya ile paylaş. <br><br>
                             Aylık 50.000
                            TL ile 500.000 tl arasında linklerinden nakit gelir elde etme hakkı kazan! <br><br> Emlak kulüp üyeleri arasından en başarılı ilk yüz
                            kişiye süpriz hediyeler!                       </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection

@section('scripts')
    <script>
        $(".accordion li").click(function() {
            $(this).closest(".accordion").hasClass("one-open") ? ($(this).closest(".accordion").find("li")
                    .removeClass("active"), $(this).addClass("active")) : $(this).toggleClass("active"),
                "undefined" != typeof window.mr_parallax && setTimeout(mr_parallax.windowLoad, 500)
        });
    </script>
@endsection
