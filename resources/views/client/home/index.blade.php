@extends('client.layouts.master')

@section('content')
    <meta name="description" content="Emlak Sepette">
    <meta name="author" content="Master Girişim">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <title>Emlak Sepette</title>
    <style>
        section.portfolio .slick-slide {
            margin-right: 10px;
        }

        section.portfolio .slick-active:first-child {
            margin-left: 0;
        }

        section.portfolio .slick-active:last-child {
            margin-right: 0 !important;
        }


        section.portfolio .slick-track {
            float: left;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
        integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @php
        if (!function_exists('convertMonthToTurkishCharacter')) {
            function convertMonthToTurkishCharacter($date)
            {
                $aylar = [
                    'January' => 'Ocak',
                    'February' => 'Şubat',
                    'March' => 'Mart',
                    'April' => 'Nisan',
                    'May' => 'Mayıs',
                    'June' => 'Haziran',
                    'July' => 'Temmuz',
                    'August' => 'Ağustos',
                    'September' => 'Eylül',
                    'October' => 'Ekim',
                    'November' => 'Kasım',
                    'December' => 'Aralık',
                    'Monday' => 'Pazartesi',
                    'Tuesday' => 'Salı',
                    'Wednesday' => 'Çarşamba',
                    'Thursday' => 'Perşembe',
                    'Friday' => 'Cuma',
                    'Saturday' => 'Cumartesi',
                    'Sunday' => 'Pazar',
                    'Jan' => 'Oca',
                    'Feb' => 'Şub',
                    'Mar' => 'Mar',
                    'Apr' => 'Nis',
                    'May' => 'May',
                    'Jun' => 'Haz',
                    'Jul' => 'Tem',
                    'Aug' => 'Ağu',
                    'Sep' => 'Eyl',
                    'Oct' => 'Eki',
                    'Nov' => 'Kas',
                    'Dec' => 'Ara',
                ];
                return strtr($date, $aylar);
            }
        }

        if (!function_exists('getData')) {
            function getData($housing, $key)
            {
                $housing_type_data = json_decode($housing->housing_type_data);
                $a = $housing_type_data->$key;
                return $a[0];
            }
        }

        if (!function_exists('getImage')) {
            function getImage($housing, $key)
            {
                $housing_type_data = json_decode($housing->housing_type_data);
                $a = $housing_type_data->$key;
                return $a;
            }
        }
    @endphp

    <section class="recently portfolio bg-white homepage-5" style="padding-top: 1.5rem 0 !important;">
        <div class="container recently-slider">
            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    @foreach ($sliders as $slider)
                        <a href="{{ $slider->url }}" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                            <div class="recent-img16 sliderSize img-fluid img-center mobile-hidden"
                                style="background-image: url({{ url('storage/sliders/' . $slider->image) }});"></div>
                            <div class="recent-img16 sliderSize img-fluid img-center mobile-show heitwo"
                                style="background-image: url({{ url('storage/sliders/' . $slider->mobile_image) }});"></div>

                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="featured  home18 bg-white mb-5" style="height: 100px">
        <div class="container">

            <div class="portfolio ">
                <div class="section-title mb-3 mobileSectionTitle">
                    <h2>Popüler İnşaat Markaları</h2>
                </div>
                <div class="slick-lancers">
                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                        <a href="https://emlaksepette.com/kategori/al-sat-acil" class="homes-img">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <img loading="lazy" src="{{ asset('images/al-sat-acil-image.png') }}"
                                                alt="Al Sat Acil" class="img-responsive brand-image-pp"
                                                style="border:5px solid red;object-fit:contain;">
                                            <span style="font-size:9px !important;border:none !important">Al Sat Acil</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                        <a href="{{ route('sharer.index.view') }}" class="homes-img">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <img loading="lazy" src="{{ asset('images/emlak-kulup.png') }}"
                                                alt="Al Sat Acil" class="img-responsive brand-image-pp"
                                                style="border:5px solid #F4A226;object-fit:contain;">
                                            <span style="font-size:9px !important;border:none !important">Emlak Kulüp</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                        <a href="{{ route('real.estate.index2') }}" class="homes-img">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <img loading="lazy" src="{{ asset('images/sat-kirala.png') }}" alt="Al Sat Acil"
                                                class="img-responsive brand-image-pp"
                                                style="border:5px solid blue;object-fit:contain;">
                                            <span style="font-size:9px !important;border:none !important">Sat Kirala</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    @foreach ($brands as $brand)
                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                            <a href="{{ route('institutional.dashboard', ['slug' => Str::slug($brand->name), 'userID' => $brand->id]) }}"
                                class="homes-img">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                @if ($brand->profile_image == 'indir.png')
                                                    @php
                                                        $nameInitials = collect(preg_split('/\s+/', $brand->name))
                                                            ->map(function ($word) {
                                                                return mb_strtoupper(mb_substr($word, 0, 1));
                                                            })
                                                            ->take(1)
                                                            ->implode('');
                                                    @endphp

                                                    <div class="profile-initial">{{ $nameInitials }}</div>
                                                @else
                                                    <img loading="lazy"
                                                        src="{{ asset('storage/profile_images/' . $brand->profile_image) }}"
                                                        alt="{{ $brand->name }}" class="img-responsive brand-image-pp"
                                                        style="object-fit:contain;">
                                                @endif
                                                <span
                                                    style="font-size:9px !important;border:none !important">{{ $brand->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="container justify-content-center mt-4">

        <div class="special-button-content row">
            @foreach ($dashboardStatuses as $key => $status)
                <div
                    class="col-lg-2 col-md-6 col-sm-6 mb-3 mt-3 col-6 statusHome {{ $key == 0 ? 'd-none d-md-block' : '' }}">
                    <a href="{{ url('kategori/' . $status->slug) }}">
                        <button style="color: black; background-color: white;border:2px solid #e6e6e6" class="w-100">
                            {{ $status->name }}
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </section>


    @if ($dashboardProjects->isNotEmpty())
        <section class="popular-places home18 mb-3 mt-5">
            <div class="container">
                <div class="mb-3" style="display: flex; justify-content: space-between; align-items:center">
                    <div class="section-title">
                        <h2>Öne Çıkan Projeler</h2>
                    </div>
                    <a href="https://emlaksepette.com/kategori/tum-projeler" style="font-size: 11px;">
                        <button style="background-color: #ea2a28; color: white; padding: 5px 10px; border: none;"
                            class="w-100">
                            Tüm Projeleri Gör
                        </button>
                    </a>
                </div>
                <div class="row">
                    @foreach ($dashboardProjects as $project)
                        <x-project-card :project="$project" />
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <p>Henüz Öne Çıkarılan Proje Bulunamadı</p>
    @endif



    <section class="featured home18 bg-white mb-8">
        <div class="container mb-5">
            <div class="portfolio">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <div class="section-title mb-3 mobileSectionTitle">
                            <h2>Popüler Gayrimenkul Markaları</h2>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 text-end">
                        <div class="featured-heads mb-3">
                            <div class="section-title">
                                <h2>Emlak İlanları</h2>
                            </div>
                            <div>
                                <a href="https://emlaksepette.com/kategori/emlak-ilanlari" style="font-size: 11px;">
                                    <button style="background-color: #ea2a28; color: white; padding: 5px 10px; border: none;" class="w-100">
                                        Tümünü Gör
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="job_clientSlide">
                        @foreach ($housingBrands as $brand)
                        <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                            <a href="{{ route('institutional.dashboard', ['slug' => Str::slug($brand->name), 'userID' => $brand->id]) }}" class="homes-img">
                                <div class="landscapes">
                                    <div class="project-single">
                                        <div class="project-inner project-head">
                                            <div class="homes">
                                                @if ($brand->profile_image == 'indir.png')
                                                    @php
                                                        $nameInitials = collect(preg_split('/\s+/', $brand->name))
                                                            ->map(function ($word) {
                                                                return mb_strtoupper(mb_substr($word, 0, 1));
                                                            })
                                                            ->take(1)
                                                            ->implode('');
                                                    @endphp
                                                    <div class="profile-initial">{{ $nameInitials }}</div>
                                                @else
                                                    <img loading="lazy" src="{{ asset('storage/profile_images/' . $brand->profile_image) }}" alt="{{ $brand->name }}" class="img-responsive brand-image-pp" style="object-fit:contain;">
                                                @endif
                                                <span style="font-size:9px !important;border:none !important">{{ $brand->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                </div>
            </div>
        </div>
    </section>
    
    
    

    @if ($housings->isNotEmpty())
        <section class="featured portfolio rec-pro disc bg-white mt-5">
            <div class="container">
                <div class="mobile-show">
                    <div id="housingMobileRow">
                        @forelse ($housings->take(4) as $housing)
                            @php($sold = $housing->sold)
                            @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                                <x-housing-card-mobile :housing="$housing" :sold="$sold" />
                            @endif
                        @empty
                            <p>Henüz İlan Yayınlanmadı</p>
                        @endforelse
                    </div>
                    <button id="loadMoreMobileButton" style="display: block;">Daha Fazlasını Gör</button>
                    <div class="ajax-load" style="display: none;">
                        <div class="spinner-border" role="status"></div>
                    </div>
                </div>

                <div class="mobile-hidden" style="margin-top: 20px">
                    <section class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container" id="housingContainer">
                            <div class="row" id="housingRow">
                                @forelse ($housings->take(4) as $housing)
                                    @php($sold = $housing->sold)
                                    @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                                        <div class="col-md-3">
                                            <x-housing-card :housing="$housing" :sold="$sold" />
                                        </div>
                                    @endif
                                @empty
                                    <p>Henüz İlan Yayınlanmadı</p>
                                @endforelse
                            </div>
                            <div class="text-center">
                                <button id="loadMoreButton" class="btn btn-primary my-3"
                                    style="display: none; margin: 0 auto;">Daha Fazlasını Gör</button>
                                <div class="ajax-load" style="display: none;">
                                    <div class="spinner-border" role="status"></div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>

        </div>


        </div>
        </section>
    @endif




    <!-- START SECTION RECENTLY PROPERTIES -->
    {{-- <section class="recently popular-places bg-white homepage-5" style=" margin-bottom: 50px; ">
        <div class="container recently-slider">

            <div class="portfolio right-slider">
                <div class="owl-carousel home5-right-slider">
                    @foreach ($footerSlider as $slider)
                        <div class="inner-box">
                            <a href="#" class="recent-16" data-aos="fade-up" data-aos-delay="150">
                                <div class="recent-img16 sliderSize img-fluid img-center mobile-hidden"
                                    style="background-image: url({{ url('storage/footer-sliders/' . $slider->image) }});">
                                </div>
                                <div class="recent-img16 sliderSize img-fluid img-center mobile-show heitwo"
                                    style="background-image: url({{ url('storage/footer-sliders/' . $slider->mobile_image) }});">
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section> --}}

    {{-- @if (Auth::check() && Auth::user()->type != '3')
        <!-- HTML -->
        <button class="chatbox-open">
            <i class="fa fa-comment" aria-hidden="true"></i>
        </button>
        <button class="chatbox-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </button>
        <div class="chatbox-popup">
            <header class="chatbox-popup__header">
                <aside style="flex:8">
                    <h4 style="color: white">Emlak Sepette Canlı Destek</h4>
                </aside>
            </header>
            <main class="chatbox-popup__main">
                <div class="chatbox-messages">
                    <div class="msg left-msg">

                        <div class="msg-bubble">

                            <div class="msg-text">
                                Merhaba size nasıl yardımcı olabiliriz ?
                            </div>
                        </div>
                    </div>

                </div>
            </main>
            <footer class="chatbox-popup__footer">
                <aside style="flex:10">
                    <textarea id="userMessage" type="text" placeholder="Mesajınızı Yazınız..." autofocus
                        onkeydown="handleKeyPress(event)"></textarea>
                </aside>
                <aside style="flex:1;color:#888;text-align:center;">
                    <button onclick="sendMessage()" class="btn btn-primary"><i class="fa fa-paper-plane"
                            aria-hidden="true"></i></button>
                </aside>
            </footer>
        </div>
    @endif --}}
    @include('cookie-consent::index')
    @if ((Auth::check() && Auth::user()->has_club == 0) || !Auth::check())
        <div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document"
                style="height: 100%;margin:0 auto;display:flex;justify-content:center;align-items:center">
                <div class="modal-content">
                    <div class="modal-body modal12">
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="modal-bg">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <i class="fa fa-close"></i>
                                        </button>
                                        <div class="offer-content">
                                            <img loading="lazy" src="{{ asset('images/emlak-kulup-banner.png') }}"
                                                class="img-fluid blur-up lazyloaded" alt="">
                                            <h2>Sen de kazananlar kulübündensin ! <br> Emlak Kulübüne üye ol, dilediğin
                                                kadar paylaş; paylaştıkça kazan!</h2>
                                            <a @if (Auth::check()) href="{{ route('institutional.sharer.index') }}"
                                           @else href="{{ route('client.login') }}" @endif
                                                style="font-size: 11px;display:flex;align-items:center;justify-content:center">
                                                <button
                                                    style="background-color: #ea2a28; color: white; padding: 10px; border: none; width:150px">
                                                    SEN DE KATIL !
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Önce, çerezin zaten ayarlanıp ayarlanmadığını kontrol ediyoruz
                var lastShownDate = getCookie("modalShownDate");

                // Eğer çerez yoksa veya bugün gösterilmediyse, modalı göster ve çerezi ayarla
                if (!lastShownDate || lastShownDate !== getCurrentDate()) {
                    setTimeout(function() {
                        $('#customModal').modal('show');
                    }, 5000);

                    // Çerezi bugünün tarihi ile ayarla
                    setCookie("modalShownDate", getCurrentDate(), 1); // Çerez 1 gün boyunca geçerli olacak
                }
            });

            // Bir çerez ayarlamak için fonksiyon
            function setCookie(name, value, days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); // Çerez 1 gün geçerli
                var expires = "expires=" + date.toUTCString();
                document.cookie = name + "=" + value + ";" + expires + ";path=/";
            }

            // Çerez değeri almak için fonksiyon
            function getCookie(name) {
                var nameEQ = name + "=";
                var ca = document.cookie.split(';');
                for (var i = 0; i < ca.length; i++) {
                    var c = ca[i].trim();
                    if (c.indexOf(nameEQ) === 0) {
                        return c.substring(nameEQ.length, c.length);
                    }
                }
                return null;
            }

            // Geçerli tarihi YYYY-MM-DD formatında almak için fonksiyon
            function getCurrentDate() {
                var date = new Date();
                return date.toISOString().split('T')[0];
            }
        </script>
    @endif

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Include Toastify CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        var page = 1;
        var maxPages = 4; // Maksimum sayfa sayısını buraya girin
        var isLoading = false;
        var itemsPerLoad = 20; // Yüklenecek öğe sayısı
        var initialLoad = true; // Başlangıçta ilk yükleme kontrolü

        function loadMoreHousings() {
            if (isLoading || page >= maxPages) return;
            isLoading = true;
            $('.ajax-load').show();

            page++;
            var url = "{{ route('load-more-housings') }}?page=" + page;


            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('housingRow').innerHTML += data;
                    isLoading = false;
                    $('.ajax-load').hide();

                    if (initialLoad && page * itemsPerLoad >= 40) {
                        document.getElementById('loadMoreButton').style.display = 'block';
                        window.removeEventListener('scroll', onScrollLoadMoreHousings);
                        initialLoad = false;
                    } else if (page >= maxPages) {
                        document.getElementById('loadMoreButton').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    isLoading = false;
                    $('.ajax-load').hide();
                });
        }

        function loadMoreMobileHousings() {
            if (isLoading || page >= maxPages) return;
            isLoading = true;
            $('.ajax-load').show();

            page++;
            var url = "{{ route('load-more-mobile-housings') }}?page=" + page;

            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('housingMobileRow').innerHTML += data;
                    isLoading = false;
                    $('.ajax-load').hide();

                    if (initialLoad && page * itemsPerLoad >= 40) {
                        document.getElementById('loadMoreMobileButton').style.display = 'block';
                        window.removeEventListener('scroll', onScrollLoadMoreMobileHousings);
                        initialLoad = false;
                    } else if (page >= maxPages) {
                        document.getElementById('loadMoreMobileButton').style.display = 'none';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    isLoading = false;
                    $('.ajax-load').hide();
                });
        }

        function onScrollLoadMoreHousings() {
            if (window.innerWidth >= 768 && !isLoading) {
                var housingRow = document.getElementById('housingRow');
                if (window.scrollY + window.innerHeight >= housingRow.offsetTop + housingRow.offsetHeight - 50) {
                    loadMoreHousings();
                }
            }
        }

        function onScrollLoadMoreMobileHousings() {
            if (window.innerWidth < 768 && !isLoading) {
                var housingMobileRow = document.getElementById('housingMobileRow');
                if (window.scrollY + window.innerHeight >= housingMobileRow.offsetTop + housingMobileRow.offsetHeight -
                    50) {
                    loadMoreMobileHousings();
                }
            }
        }

        document.getElementById('loadMoreButton').addEventListener('click', loadMoreHousings);
        document.getElementById('loadMoreMobileButton').addEventListener('click', loadMoreMobileHousings);

        window.addEventListener('scroll', onScrollLoadMoreHousings);
        window.addEventListener('scroll', onScrollLoadMoreMobileHousings);
    </script>

    <script>
         $('.job_clientSlide').slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: true,
                arrows: false,
                adaptiveHeight: true,
                responsive: [{
                    breakpoint: 1292,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true,
                        arrows: false
                    }
                }, {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: true,
                        arrows: false
                    }
                }, {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true,
                        arrows: false
                    }
                }]
            });

    </script>
@endsection

@section('styles')
    <style>
        .profile-initial {
            font-size: 20px;
            color: #e54242;
            background: white;
            padding: 5px;
            border: 2px solid #e6e6e6;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
        }

        .modal12 {
            background-image: linear-gradient(135deg, #ea2a285.77%, #fff 5.77%, #fff 25%, #111 25%, #111 30.77%, #fff 30.77%, #fff 50%, #ea2a2850%, #ea2a2855.77%, #fff 55.77%, #fff 75%, #111 75%, #111 80.77%, #fff 80.77%, #fff 100%);
            background-size: 36.77px 36.77px;
            background-color: white;
        }

        .modal-body .modal-bg {
            background-color: #fff;
            padding: 45px;
        }

        .modal-bg .offer-content h2 {
            margin-bottom: 30px;
            text-align: center;
            color: #222;
        }

        .modal-bg .btn-close {
            padding-right: 10px;
            padding-top: 5px;
            position: absolute;
            right: 26px;
            top: 12px;
            background: transparent;
            border: none;
            font-size: 15px;
        }

        .modal-bg .offer-content img {
            margin-bottom: 40px;
        }

        .slick-slider .slick-track {
            display: flex !important;
            justify-content: flex-start !important;
            align-items: flex-start !important;
            transform: none !important;
            width: auto !important;
        }

        .slick-slider .slick-slide {
            float: none !important;
            display: inline-block !important;
        }
    </style>
@endsection
