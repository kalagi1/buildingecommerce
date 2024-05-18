@extends('client.layouts.master')

@section('content')
    <section style="background-color: rgb(247, 247, 247);">
        <div class="div" style="padding-top: 40px; padding-bottom: 40px;">


            <div class="container">
                <div class="sec-title">
                    <h2 style="font-size: 20px">Emlak Sepette ile <span style="color: #ea2a28!important;font-weight:700">Sat
                            Kirala</span> </h2>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-4">
                        <div class="div"
                            style="background-color: rgb(255, 255, 255); border: 1px solid rgb(205, 205, 211); box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 15px; text-align: center; padding: 29px; border-radius: 20px; ">
                            <img src="https://www.zillowstatic.com/bedrock/app/uploads/sites/5/2024/04/homepage-spot-agent-lg-1.webp"
                                style="border-radius: 50px; width:160px; height:160px" alt="">
                            <h4 style="margin-top: 20px; font-weight: 700;font-size:15px;color:black !important">Kirala</h4>
                            <p>Arsa, konut, işyeri, turistik tesis, devremülk tüm
                                gayrimenkullerinizin satış veya kiralamasını
                                emlaksepette.com sizin yerinize yapsın
                                zamanınız size kalsın.
                            </p>
                            <button onclick="checkAuth()" style="font-weight: 700;width:100px" type="button"
                                class="btn btn-outline-danger">Kirala</button>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="div"
                            style="background-color: rgb(255, 255, 255); border: 1px solid rgb(205, 205, 211); box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 15px; text-align: center; padding: 29px; border-radius: 20px; ">

                            <img src="https://www.zillowstatic.com/bedrock/app/uploads/sites/5/2024/04/homepage-spot-sell-lg-1.webp"
                                style="border-radius: 50px; width:160px; height:160px" alt="">
                            <h4 style="margin-top: 20px; font-weight: 700;font-size:15px;color:black !important">Sat</h4>
                            <p>Arsa, konut, işyeri, turistik tesis, devremülk tüm
                                gayrimenkullerinizin satış veya kiralamasını
                                emlaksepette.com sizin yerinize yapsın
                                zamanınız size kalsın.
                            </p>
                            <button style="font-weight: 700;width:100px" onclick="checkAuth()" type="button"
                                class="btn btn-outline-danger">Sat</button>

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="div"
                            style="background-color: rgb(255, 255, 255); border: 1px solid rgb(205, 205, 211); box-shadow: rgba(0, 0, 0, 0.15) 0px 4px 15px; text-align: center; padding: 29px; border-radius: 20px; ">

                            <img src="https://www.zillowstatic.com/bedrock/app/uploads/sites/5/2024/04/homepage-spot-rent-lg-1.webp"
                                style="border-radius: 50px; width:160px; height:160px" alt="">
                            <h4 style="margin-top: 20px; font-weight: 700;font-size:15px;color:black !important">Neden Sat
                                Kirala?</h4>
                            <p>Arsa, konut, işyeri, turistik tesis, devremülk tüm
                                gayrimenkullerinizin satış veya kiralamasını
                                emlaksepette.com sizin yerinize yapsın
                                zamanınız size kalsın.
                            </p>
                            <a href="">
                                <button style="font-weight: 700;width:100px" type="button"
                                    class="btn btn-outline-danger">Detaylı
                                    Bilgi</button>
                            </a>
                        </div>
                    </div>






                </div>
            </div>
        </div>
    </section>
    <section style="margin-top: 50px">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-7">
                    <div class="sec-title">
                        <h2 style="font-size: 20px">Hızlı ve güvenli satışın yolu</h2>
                    </div>
                    <p>Arsa, konut, işyeri, turistik tesis, devremülk tüm
                        gayrimenkullerinizin satış veya kiralamasını
                        emlaksepette.com sizin yerinize yapsın
                        zamanınız size kalsın.
                        Formu doldur bilgilerini gir kolay sat kirala!Arsa, konut, işyeri, turistik tesis, devremülk tüm
                        gayrimenkullerinizin satış veya kiralamasını
                        emlaksepette.com sizin yerinize yapsın
                        zamanınız size kalsın.
                        Formu doldur bilgilerini gir kolay sat kirala!</p>
             
                        <button style="margin-top: 20px;" onclick="checkAuth()" type="button" class="btn btn-lg btn-danger">Formu
                            Doldur</button>
                </div>
                <div class="col-md-5">
                    <img src="https://delivery.digitalassets.zillowgroup.com/api/public/content/2x_Miso_FSBO_Vector_CMS_Full.png?v=e53ae166" alt="" style="width: 100%">
                </div>
            </div>
            <div class="row mt-2" style="margin-bottom:30px">
                <div class="col-md-4">
                    <div class="sec-title">
                        <h2 style="font-size: 15px">Sat Kirala Nedir ?</h2>
                    </div>
                    <ul style="list-style: none; margin: 0; padding: 0; margin-top: 20px;">
                        <li style="margin-bottom: 10px;"> <i class="fa fa-check" style="color: #63E6BE; font-size: 20px; margin-right: 5px;"></i> Potential for
                            bidding wars</li>
                        <li style="margin-bottom: 10px;"> <i class="fa fa-check" style="color: #63E6BE; font-size: 20px; margin-right: 5px;"></i> Potential for
                            bidding wars</li>
                        <li style="margin-bottom: 10px;"> <i class="fa fa-check" style="color: #63E6BE; font-size: 20px; margin-right: 5px;"></i> Potential for
                            bidding wars</li>
                        <li style="margin-bottom: 10px;"> <i class="fa fa-check" style="color: #63E6BE; font-size: 20px; margin-right: 5px;"></i> Potential for
                            bidding wars</li>

                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="sec-title">
                        <h2 style="font-size: 15px">Sat Kirala Avantajları</h2>
                    </div>
                    <div style="margin-top: 20px;">
                        <p>Sat kirala sistemi gayrimenkullerini hızlı güvenli ve değerinde satmak isteyen bireysel
                            satıcıların gayrimenkullerin platforma kayıtlı kurumsal emlak firmaları vasıtasıyla satışını
                            sağlayan bir hizmettir.</p>
                    </div>
                  
                </div>
            </div>
            <hr>
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
                                <span>
                                    Sat Kirala nedir?
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-down"></i>

                            </div>
                            <div class="content">
                                <p>
                              
                                    Sat kirala sistemi gayrimenkullerini hızlı güvenli ve değerinde satmak isteyen bireysel
                                    satıcıların gayrimenkullerin platforma kayıtlı kurumsal emlak firmaları vasıtasıyla
                                    satışını sağlayan bir hizmettir.
                                
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>
                                    Hangi Gayrimenkuller Sat Kirala ile satılabilir?
                                
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <ul class="fa-ul mt-3 mb-3">
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Arsa</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Konut</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> İşyeri</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Turistik Tesis</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Devre Mülk</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Prefabrik</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Bina</li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="title">
                                <span>
                                    Satış süreci ne kadar sürüyor?
                                
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>

                            </div>
                            <div class="content">
                                <p>
                                 
                                    İlanınız kurumsal satıcımıza ulaştığında onayınız doğrultusunda minimum 90 gün olmak
                                    üzere kurumsal satıcımız ile yapacağınız yetkilendirme sözleşmesi süresi boyunca satış
                                    süreçleri tarafımızdan yönetilir. Satış gerçekleşmediği taktirde onayınız doğrultusunda
                                    hiçbir bedel ödemeden satış sürecini sonlandırabilirsiniz.
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="title">

                                <span>
                                    Süreç nasıl işliyor?
                                
                                </span>
                                <i class="accordion-toggle-icon fas fa-chevron-right"></i>
                            </div>
                            <div class="content">
                                <ul class="fa-ul mt-3 mb-3">
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Web sitemiz veya
                                        mobil uygulamamız üzerinden ilan bilgileri girilir</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Kriterlere uygun
                                        ilanlar onaylanır.</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Emlak sepette
                                        sistemine dahil olan kurumsal satıcılara ilanınız ulaştırılır.</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Sat Kirala sistemine
                                        dahil olan kurumsal satıcılara ulaştırılır.</li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Kurumsal satıcımız
                                        sizinle temas kurarak gayrimenkulünüzün Fotoğraf çekimleri, değerleme,
                                        potansiyel alıcı/müşteri bulma, satış sürecindeki devir ve tüm yasal işlemleri
                                        adınıza takip etmektedir. </li>
                                    <li><span class="fa-li"><i class="fa fa-circle"></i></span> Satış süreci olumlu
                                        tamamlandığında noter ve devi işlemleri sonrasında satışınız tamamlanmış olur.
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                    <!--end of accordion-->
                </div>
            </div>
        </div>
    </section>
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
    <script>
        function checkAuth() {
            if ({{ auth()->check() ? 'true' : 'false' }}) {
                window.location.href = "{{ route('institutional.housing.create.v3') }}";
            } else {
                window.location.href = "{{ route('client.login') }}";
            }
        }
    </script>
    <script>
        $(".accordion li").click(function() {
            $(".faq li").not(this).removeClass("active");
            $(".faq li i").not($(this).find("i")).removeClass("fa-chevron-down").addClass("fa-chevron-right");
            $(this).toggleClass("active").find("i").toggleClass("fa-chevron-right", !$(this).hasClass("active"))
                .toggleClass("fa-chevron-down", $(this).hasClass("active"));

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
