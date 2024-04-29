@extends('client.layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-5 mb-3">
                <div>
                    <p class="message">Hızlı güvenli ve kolay satışın yolu... Emlaksepette/Sat Kirala</p>
                </div>

                <div style="margin-top: 17px;margin-bottom:40px;">
                    <p class="message2">Arsa, konut, işyeri, turistik tesis, devremülk tüm <br> gayrimenkullerinizin satış
                        veya kiralamasını <br> <span class="text-red">emlaksepette.com</span> sizin yerinize yapsın <br>
                        zamanınız size kalsın.</p>
                </div>

                <div style="margin-top: 17px;">
                    <p class="message2 " style=" border-bottom: 2px solid #FF6B6B; padding-bottom:5px; width:74%; ">Formu
                        doldur bilgilerini gir kolay sat kirala!</p>
                </div>

                {{-- <div style="margin-top: 40px">
                    <a href="{{ route('real.estate.index') }}" class="btnForm">Formu Doldur</a>
                </div> --}}

                <div style="margin-top: 40px">
                    <a href="#" onclick="checkAuth()" class="btnForm">Ücretsiz İlan Yayınla</a>
                </div>

                <script>
                    function checkAuth() {
                        if ({{ auth()->check() ? 'true' : 'false' }}) {
                            window.location.href = "{{ route('institutional.housing.create.v3') }}";
                        } else {
                            window.location.href = "{{ route('client.login') }}";
                        }
                    }
                </script>
            </div>

            <div class="col-md-6 mt-3 mb-3">
                <img src="{{ asset('sat_kirala/sat_kirala.svg') }}" alt="SVG Resim" class="gorsel" width="200%"
                    height="auto">
            </div>
        </div>

        <div class="row" style="margin-top: 70px; margin-bottom:70px;">
            <div class="col-md-12 text-center">
                <p class="messageBaslik">Sat Kiralanın Avantajları</p>
            </div>
        </div>

        <div class="row" style="margin-top:70px; ">
            <div class="card-container mb-5">
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="mt-3 mb-3" style="display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('sat_kirala/sales_user.svg') }}" alt="SVG Resim" class="gorsel"
                                style="width: 13%; height: auto; ">
                        </div>

                        <p class="cardP1">Sat Kirala ile Hızlı Satış</p>
                        <p class="cardP2">Satmak veya kiralamak istediğiniz gayrimenkulünüzün bilgilerini girin. Binlerce
                            profesyonel emlak danışmanı vasıtasıyla hızlı ve kolayca satışını sizin yerinize biz sağlayalım.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="mt-3 mb-3" style="display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('sat_kirala/security.svg') }}" alt="SVG Resim" class="gorsel" width="13%"
                                height="auto">
                        </div>
                        <p class="cardP1">Kapora Güvence Sistemi</p>
                        <p class="cardP2">Gayrimenkulünüzün satışı tamamlandığı takdirde kapora güvence sistemiyle kaporanız
                            bizim güvencemiz altındadır.</p>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <div class="card">
                        <div class="mt-3 mb-3" style="display: flex; align-items: center; justify-content: center;">
                            <img src="{{ asset('sat_kirala/user_fill.svg') }}" alt="SVG Resim" class="gorsel" width="13%"
                                height="auto">
                        </div>
                        <p class="cardP1">Emlaksepette.com Uzmanlğı</p>
                        <p class="cardP2">Emlaksepette.com ile tüm satış veya kiralama süreçlerinde profesyonel ve güvenilir
                            hizmet alırsınız.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="divIlan">
        <div class="container">
            <div class="p-1">
                <div class="row " style="margin-top: 70px; margin-bottom:70px;">
                    <div class="col-md-12 text-center">
                        <p class="messageBaslik">İlanımı nasıl satarım ?</p>
                    </div>
                </div>

                <div class="row mt-5 " style="margin-bottom: 80px;">
                    <div class="card-containerIlan mb-5">
                        <div class="col-md-4 col-12">
                            <div class="card">
                                <div class="mt-3 mb-3">
                                    <img src="{{ asset('sat_kirala/form.svg') }}" alt="SVG Resim" class="gorsel"
                                        width="16%" height="auto"
                                        style=" border-bottom: 2px solid red; padding-bottom:10px;">
                                </div>

                                <p class="cardP3 mt-5">Formu Doldurun</p>
                                <p class="cardP4 mt-3">Satmak veya kiralamak istediğiniz gayrimenkulünüzün ilan bilgilerini
                                    girin (Fiyat,Lokasyon vb) profesyonel gayrimenkul danışmanlarımız sizi arasın.</p>
                            </div>
                            <div class="mt-3 mb-3">
                                <img src="{{ asset('sat_kirala/sağa_ok.svg') }}" alt="SVG Resim" class="gorselSagOk"
                                    width="30%" height="auto">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card">
                                <div class="mt-3 mb-3">
                                    <img src="{{ asset('sat_kirala/Vector.svg') }}" alt="SVG Resim" class="gorsel"
                                        width="16%" height="auto"
                                        style=" border-bottom: 2px solid red; padding-bottom:10px;">
                                </div>
                                <p class="cardP3 mt-5">Profesyonel Emlak Danışmanlığı</p>
                                <p class="cardP4 mt-3">İlanınız gerekli incelemeler sonrasında onaylandığında profesyonel
                                    emlak danışmanlarımız satış süreciyle ilgili tüm süreçlerde danışmanlık hizmeti
                                    vermektedir. Gayrimenkulünüzün Fotoğraf çekimleri, potansiyel alıcı/müşteri bulma, satış
                                    sürecindeki devir ve tüm yasal işlemleri adınıza takip etmektedir.</p>
                            </div>
                            <div class="mt-3 mb-3">
                                <img src="{{ asset('sat_kirala/yukari_ok.svg') }}" alt="SVG Resim"
                                    class="gorselYukariOk" width="30%" height="auto">
                            </div>
                        </div>

                        <div class="col-md-4 col-12">
                            <div class="card">
                                <div class="mt-3 mb-3">
                                    <img src="{{ asset('sat_kirala/money.svg') }}" alt="SVG Resim" class="gorsel"
                                        width="16%" height="auto"
                                        style=" border-bottom: 2px solid red; padding-bottom:10px;">
                                </div>
                                <p class="cardP3 mt-5">Hızlı Güvenli ve Kolay Satın</p>
                                <p class="cardP4 mt-3">Gayrimenkulünüzün sorunsuz zahmetsiz hızlı ve kolay satışını
                                    tamamlayın.</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <div class="row" style="margin-bottom:50px;">
            <div class="col-md-12 text-center">
                <p class="messageBaslik">Sıkça Sorulan Sorular</p>
            </div>
        </div>

        <div class="row" style="margin-bottom: 70px;">
            <div class="col-md-12">
                <div class="kategori-container">
                    <ul class="kategori-listesi">
                        <li class="kategori" data-category="kategori1">Genel Bilgiler</li>
                        <li class="kategori" data-category="kategori2">Fiyatlama Süreci</li>
                        <li class="kategori" data-category="kategori3">Randevu Süreci</li>
                        <li class="kategori" data-category="kategori4">Başvuru ve Onay Süreci</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row" style="margin:-top:70px;margin-bottom:60px; ">
            <div class="col-md-12">
                <div id="kategori1Content" class="accordion-content">

                    {{-- GENEL bilgiler soruları --}}
                    <div class="accordion" id="accordionExample">

                        <div class="card accordionCard">
                            <div class="card-header" id="headingOne">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Sat Kirala nedir?
                                    </button>
                                    </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    Sat kirala sistemi gayrimenkullerini hızlı güvenli ve değerinde satmak isteyen bireysel
                                    satıcıların gayrimenkullerin platforma kayıtlı kurumsal emlak firmaları vasıtasıyla
                                    satışını sağlayan bir hizmettir.
                                </div>
                            </div>
                        </div>

                        <div class="card accordionCard">
                            <div class="card-header" id="headingTwo">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Hangi Gayrimenkuller Sat Kirala ile satılabilir?
                                    </button>
                                    </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <ul class="fa-ul">
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Arsa</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Konut</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> İşyeri</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Turistik Tesis</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Devre Mülk</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Prefabrik</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Bina</li>
                                    </ul>


                                </div>
                            </div>
                        </div>

                        <div class="card accordionCard">
                            <div class="card-header" id="headingFour">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        Süreç nasıl işliyor?
                                    </button>
                                    </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    <ul class="fa-ul">
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Web sitemiz veya
                                            mobil uygulamamız üzerinden ilan bilgileri girilir</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Kriterlere uygun
                                            ilanlar onaylanır.</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Emlak sepette
                                            sistemine dahil olan kurumsal satıcılara ilanınız ulaştırılır.</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Sat Kirala sistemine
                                            dahil olan kurumsal satıcılara ulaştırılır.</li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Kurumsal satıcımız
                                            sizinle temas kurarak gayrimenkulünüzün Fotoğraf çekimleri, değerleme,
                                            potansiyel alıcı/müşteri bulma, satış sürecindeki devir ve tüm yasal işlemleri
                                            adınıza takip etmektedir. </li>
                                        <li><span class="fa-li"><i class="fas fa-circle"></i></span> Satış süreci olumlu
                                            tamamlandığında noter ve devi işlemleri sonrasında satışınız tamamlanmış olur.
                                        </li>
                                    </ul>


                                </div>
                            </div>
                        </div>

                        <div class="card accordionCard">
                            <div class="card-header" id="headingThree">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Satış süreci ne kadar sürüyor?
                                    </button>
                                    </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    İlanınız kurumsal satıcımıza ulaştığında onayınız doğrultusunda minimum 90 gün olmak
                                    üzere kurumsal satıcımız ile yapacağınız yetkilendirme sözleşmesi süresi boyunca satış
                                    süreçleri tarafımızdan yönetilir. Satış gerçekleşmediği taktirde onayınız doğrultusunda
                                    hiçbir bedel ödemeden satış sürecini sonlandırabilirsiniz.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="kategori2Content" class="accordion-content" style="display: none;">

                    {{-- Fiyatlama Süreci soruları --}}
                    <div class="accordion" id="accordionExample">

                        <div class="card accordionCard">
                            <div class="card-header" id="headingOne">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Sat Kirala sistemi ile yayınladığım ilanımın fiyatı nasıl belirleniyor?
                                    </button>
                                    </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    Web sitemiz yada mobil uygulamamız üzerinden bize ulaştırdığınız gayrimenkulün fiyatını
                                    piyasa koşullarına göre serbest bir şekilde siz belirlersiniz.
                                </div>
                            </div>
                        </div>

                        <div class="card accordionCard">
                            <div class="card-header" id="headingTwo">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left collapsed" type="button"
                                        data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        Satış gerçekleştiğinde mülk sahibinden komisyon alınıyor mu?
                                    </button>
                                    </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    Sat Kirala sistemine katılım ücretsizdir. Gayrimenkulünü satmak isteyen
                                    kullanıcılarımızdan herhangi bir komisyon veya ücret alınmamaktadır.
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="kategori3Content" class="accordion-content" style="display: none;">
                    {{-- Randevu Süreci soruları --}}
                    <div class="accordion" id="accordionExample">

                        <div class="card accordionCard">
                            <div class="card-header" id="headingOne">
                                <h3 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button"
                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        Sat kirala üzerinden nasıl randevu alabilirim?
                                    </button>
                                    </h2>
                            </div>

                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                data-parent="#accordionExample">
                                <div class="card-body">
                                    Web sitemiz yada mobil uygulamamız üzerinden girdiğiniz ilanınız onaylandıktan sonra
                                    binlerce kurumsal mağazamız içerisinden lokasyonunuza en uygun konumdaki kurumsal
                                    satıcımız size ulaşıp randevu alacaktır.
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div id="kategori4Content" class="accordion-content" style="display: none;">
                {{-- başvuru ve onay Süreci soruları --}}
                <div class="accordion" id="accordionExample">

                    <div class="card accordionCard">
                        <div class="card-header" id="headingOne">
                            <h3 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Başvuru ve Onay Süreci
                                </button>
                                </h2>
                        </div>

                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordionExample">
                            <div class="card-body">
                                Hangi durumlarda başvurum geçersiz olur.
                                <ul class="fa-ul">
                                    <li><span class="fa-li"><i class="fas fa-circle"></i></span> Başvuruyu yapan kişinin
                                        mutlaka tapu sahibi olması gerekmektedir.</li>
                                    <li><span class="fa-li"><i class="fas fa-circle"></i></span> Gayrimenkul üzerinde
                                        satışa engel oluşturacak kredi, rehin gibi borçlar bulunmamalıdır.</li>
                                    <li><span class="fa-li"><i class="fas fa-circle"></i></span> İlanınızın satışa
                                        çıkarılmasına onay verdiğinizde minimum 90 gün olarak düzenlenmiş yetkilendirme
                                        sözleşmesi gerekmektedir.</li>
                                    <li><span class="fa-li"><i class="fas fa-circle"></i></span> Bu şartları
                                        sağladığınızda gayrimenkulünüz satış süreci başlatılmış olur.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>


            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            // İlk kategori içeriğini aç
            $('#kategori1Content').show();

            $('.kategori').click(function() {
                var category = $(this).attr('data-category');

                // Tıklanan kategoriye ait içeriği göster
                $('#' + category + 'Content').show();

                // Diğer kategori içeriklerini gizle
                $('.accordion-content').not('#' + category + 'Content').hide();

                // Tıklanan kategoriye active sınıfını ekle, diğerlerinden kaldır
                $('.kategori').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .divIlan {
            background-color: #F6F9FF;
        }

        .gorselSagOk {
            position: absolute;
            top: -35px;
            left: 220px;
        }

        .gorselYukariOk {
            position: absolute;
            top: 230px;
            left: 330px;
        }

        .accordionCard {
            margin-bottom: 40px;
        }

        .accordionCard .card-body {
            font-size: 13px;
        }

        .btn-link {
            font-size: 16px !important;
        }

        .btn-link:focus,
        .btn-link:hover {
            text-decoration: none !important;
            background-color: transparent !important;
            box-shadow: none !important;
            outline: none !important;
            /* Buton odaklandığında etrafındaki kenarlığı da kaldır */
        }

        .kategori-container {
            text-align: center;
            /* Kategorileri yatayda ortala */
        }

        .kategori-listesi {
            list-style-type: none;
            /* Sırasız liste öğelerinin işaretlerini kaldır */
            padding: 0;
            margin: 0;
        }

        .kategori {
            display: inline-block;
            /* Yatayda hizala */
            padding: 5px 10px;
            background-color: #f0f0f0;
            margin-right: 40px;
            /* İhtiyaca göre sağ tarafta boşluk bırakabilirsiniz */
            font-size: 20px;
            cursor: pointer;
            color: #333333;
            border-bottom: 2px solid gray;
            transition: color 0.3s, border-bottom 0.3s;
        }

        .collapse:hover {
            background-color: white;
        }

        .kategori:hover {
            color: #0056b3;
            border-bottom: 2px solid #0056b3;
        }

        .messageBaslik {
            color: #333333;
            font-size: 32px;
        }

        .message {
            width: 550px;
            height: 111px;
            font-size: 28px;
            line-height: 55.42px;
            color: #333333;
        }

        .message2 {
            gap: 0px;
            opacity: 0px;
            font-family: 'Montserrat', sans-serif;
            font-size: 15px;
            font-weight: 400;
            line-height: 30px;
            text-align: left;
            color: #777777;
        }

        .btnForm {
            width: 270px !important;
            height: 45px !important;
            gap: 0px;
            opacity: 0px;
            background-color: #5296df;
            border: 1px solid #5296df;
            color: aliceblue;
            font-size: 16px;
            padding: 10px 70px 10px 70px;
        }

        .btnForm:hover {
            width: 270px !important;
            height: 45px !important;
            gap: 0px;
            opacity: 0px;
            background-color: #5296df;
            border: 1px solid #5296df;
            color: aliceblue;
            font-size: 16px;
            padding: 10px 70px 10px 70px;
        }

        .btnShare {
            width: 270px !important;
            height: 45px !important;
            gap: 0px;
            opacity: 0px;
            background-color: transparent;
            /* Arka plan rengini kaldırır */
            border: 1px solid #5296df;
            color: black;
            /* Metin rengini beyaz yapar */
            font-size: 16px;
            padding: 10px 70px 10px 70px;
        }

        .btnShare:hover {
            border-color: #fff;
            /* Üzerine gelindiğinde kenarlık rengini değiştir */
        }

        .card-container {
            display: flex;
        }

        .card-containerIlan {
            display: flex;
        }

        @media (max-width: 768px) {
            .card-containerIlan {
                display: block;
            }

            .kategori-listesi {
                list-style-type: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .kategori {
                flex-basis: calc(15% - 0px);
                margin: 0px;
                font-size: 12px;
            }

            .gorselSagOk {
                transform: rotate(90deg);
                position: absolute;
                top: 230px;
                left: 290px;
            }

            .gorselYukariOk {
                transform: rotate(160deg);
                position: absolute;
                top: 290px;
            }

            .btn-link {
                font-size: 12px !important;
            }

            .accordionCard .card-body {
                font-size: 11px;
            }

        }

        .card-container .card {
            background-color: transparent;
            gap: 0px;
            opacity: 1;
            margin-right: 20px;
            height: 100%;
            padding: 15px;
            border: none;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            transition: box-shadow 0.3s ease;
        }

        .card-containerIlan .card {
            background-color: transparent;
            gap: 0px;
            opacity: 1;
            margin-right: 20px;
            border: none;
            transition: box-shadow 0.3s ease;
        }

        .cardP1 {
            color: #333333;
            font-size: 17px;
            text-align: center;
            margin-bottom: 10px;
            margin-top: 19px;
        }

        .cardP2 {
            color: #777777;
            font-size: 12px;
        }

        .cardP3 {
            color: #333333;
            font-size: 21px;
            margin-bottom: 10px;

        }

        .cardP4 {
            color: #777777;
            font-size: 12px;
        }

        .gorsel {
            gap: 0px;
            opacity: 0px;

        }
    </style>
@endsection
