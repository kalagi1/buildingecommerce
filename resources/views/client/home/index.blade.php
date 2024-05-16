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
                        <a href="{{$slider->url}}" class="recent-16" data-aos="fade-up" data-aos-delay="150">
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

   
    <section class="featured  home18 bg-white" style="height: 100px">
        <div class="container">
           
            <div class="portfolio ">
                <div class="section-title mb-3">
                    <h2>Mağaza Vitrini</h2>
                </div>
                <div class="slick-lancers">
                    <div class="agents-grid" data-aos="fade-up" data-aos-delay="150">
                        <a href="https://test.emlaksepette.com/kategori/al-sat-acil" class="homes-img">
                            <div class="landscapes">
                                <div class="project-single">
                                    <div class="project-inner project-head">
                                        <div class="homes">
                                            <img loading="lazy" src="{{ asset('images/al-sat-acil.png') }}"
                                                alt="Al Sat Acil" class="img-responsive brand-image-pp"
                                                style="border:5px solid #F4A226;object-fit:contain;">
                                            <span style="font-size:9px !important;border:none !important">Al Sat Acil</span>
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
                                                        alt="{{ $brand->name }}" class="img-responsive brand-image-pp" style="object-fit:contain;">
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
                    <a href="https://test.emlaksepette.com/kategori/tum-projeler" style="font-size: 11px;">
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


    @if ($secondhandHousings->isNotEmpty())
        <section class="featured portfolio rec-pro disc bg-white">
            <div class="container">
                <div class="featured-heads mb-3">
                    <div class="section-title">
                        <h2>Emlak İlanları</h2>
                    </div>
                    <a href="https://test.emlaksepette.com/kategori/emlak-ilanlari" style="font-size: 11px;">
                        <button style="background-color: #ea2a28; color: white;padding: 5px 10px;border:none;"
                            class="w-100">
                            Tümünü Gör
                        </button>
                    </a>
                </div>

                <div class="mobile-show">
                    <div id="housingMobileRow">
                        @forelse ($secondhandHousings->take(4) as $housing)
                            @php($sold = $housing->sold)
                            @if (!isset(json_decode($housing->housing_type_data)->off_sale1[0]) && (($sold && $sold != '1') || !$sold))
                                <x-housing-card-mobile :housing="$housing" :sold="$sold" />
                            @endif
                        @endforeach
                    </div>

                    <div class="ajax-load" style="display: none;">
                        <div class="spinner-border" role="status">
                           
                          </div>
                    </div>
                </div>

                <div class="mobile-hidden" style="margin-top: 20px">
                    <section class="properties-right list featured portfolio blog pb-5 bg-white">
                        <div class="container" id="housingContainer">
                            <div class="row" id="housingRow">
                                @forelse ($secondhandHousings->take(4) as $housing)
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
                            <div class="ajax-load" style="display: none;">
                                <div class="spinner-border" role="status">
                                   
                                  </div>
                            </div>
                        </div>
                    </section>
                </div>


            </div>
        </section>
    @endif



    <!-- START SECTION RECENTLY PROPERTIES -->
    <section class="recently popular-places bg-white homepage-5" style=" margin-bottom: 50px; ">
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
    </section>

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
    <div class="modal fade" id="customModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="height: 100%;margin:0 auto;display:flex;justify-content:center;align-items:center">
            <div class="modal-content">
                <div class="modal-body modal12">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="modal-bg">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <div class="offer-content">
                                        <img loading="lazy" src="{{ asset('images/emlak-kulup-banner.png') }}" class="img-fluid blur-up lazyloaded" alt="">
                                        <h2>Sen de kazananlar kulübündensin ! <br> Emlak Kulübüne üye ol, dilediğin kadar paylaş; paylaştıkça kazan!</h2>
                                        <a @if (Auth::check()) href="{{ route('institutional.sharer.index') }}"
                                           @else href="{{ route('client.login') }}" @endif style="font-size: 11px;display:flex;align-items:center;justify-content:center">
                                           <button style="background-color: #ea2a28; color: white; padding: 10px; border: none; width:150px">
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
        var isLoading = false;
        var housingRow = $('#housingRow');
        var housingMobileRow = $('#housingMobileRow');
        var itemsPerPage = 4;
        var maxPages = null;
        var housingCounts = @json($secondhandHousings);
        maxPages = Math.ceil(housingCounts.length / itemsPerPage);
        function centerAjaxLoadElements() {
        var ajaxLoadElements = document.querySelectorAll('.ajax-load');
        
        ajaxLoadElements.forEach(function(element) {
            element.style.display = 'flex';
            element.style.justifyContent = 'center';
            element.style.margin = '0 auto';
        });
    }
        function loadMoreHousings() {
            if (isLoading || page >= maxPages) return; 
            isLoading = true;
            centerAjaxLoadElements();
            $('.ajax-load').show();
    
            page++; 
            var url = "{{ route('load-more-housings') }}?page=" + page;
    
            fetch(url)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('housingRow').innerHTML += data;
                    isLoading = false;
                    $('.ajax-load').hide();
                })
                .catch(error => console.error('Error:', error));
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
                })
                .catch(error => console.error('Error:', error));
        }
    
        window.addEventListener('scroll', function() {
            if ($(window).scrollTop() + $(window).height() >= housingRow.offset().top + housingRow.outerHeight() -
                50 && !isLoading && window.innerWidth >= 768) {
                loadMoreHousings();
            }
            if ($(window).scrollTop() + $(window).height() >= housingRow.offset().top + housingMobileRow
                .outerHeight() -
                50 && !isLoading && window.innerWidth < 768) {
                loadMoreMobileHousings();
            }
        });
    </script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetchChatHistory();
        });

        function fetchChatHistory() {
            $.ajax({
                url: 'chat/history',
                method: 'GET',
                success: function(response) {

                    renderChatHistory(response);
                },
                error: function(error) {
                    console.error('Sohbet geçmişi alınamadı:', error);
                }
            });

        }

        function renderChatHistory(chatHistory) {
            const chatboxMessages = document.querySelector('.chatbox-messages');

            chatHistory.forEach(entry => {
                const messageElement = document.createElement('div');
                const messageType = entry.receiver_id == 4 ? 'user' : 'admin';

                messageElement.className = messageType == 'admin' ? 'msg left-msg' : 'msg right-msg';
                messageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${entry.content}
                </div>
            </div>
        `;
                chatboxMessages.appendChild(messageElement);
            });
        }


        var isFirstMessage = true;

        function sendMessage() {
            var userMessage = document.getElementById('userMessage').value;
            var chatboxMessages = document.querySelector('.chatbox-messages');

            // Kullanıcının mesajını ekle
            var userMessageElement = document.createElement('div');
            userMessageElement.className = 'msg right-msg';
            userMessageElement.innerHTML = `
            <div class="msg-bubble">
                <div class="msg-text">
                    ${userMessage}
                </div>
            </div>
        `;
            chatboxMessages.appendChild(userMessageElement);

            $.ajax({
                type: 'POST',
                url: "{{ route('messages.store') }}",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'content': userMessage,
                },
                success: function(response) {
                    // Başarıyla mesaj gönderildiğinde yapılacak işlemler
                    console.log(response.message);
                    chatboxMessages.scrollTop = chatboxMessages.scrollHeight;
                },
                error: function(error) {
                    toastr.error('Bir hata oluştu. Lütfen tekrar deneyin.');

                }
            });


            // Kullanıcının girdiği mesaj alanını temizle
            document.getElementById('userMessage').value = '';
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        $(".chatbox-open").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeIn();
        });

        $(".chatbox-close").click(() => {
            $(".chatbox-popup, .chatbox-close").fadeOut();
        });

        $(".chatbox-maximize").click(() => {
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeOut();
            $(".chatbox-panel").fadeIn();
            $(".chatbox-panel").css({
                display: "flex"
            });
        });

        $(".chatbox-minimize").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-popup, .chatbox-open, .chatbox-close").fadeIn();
        });

        $(".chatbox-panel-close").click(() => {
            $(".chatbox-panel").fadeOut();
            $(".chatbox-open").fadeIn();
        });
        $('.finish-projects-web').slick({
            infinite: false,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        })

        $('.continue-projects-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        })

        $('.secondhand-housings-web').slick({
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
            rows: 2,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 993,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        dots: false,
                        arrows: false
                    }
                }
            ]
        });
    </script>
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Corporation",
          "name": "Emlak Sepette",
          "alternateName": "Emlaksepette",
          "url": "https://test.emlaksepette.com/",
          "logo": "https://test.emlaksepette.com/images/emlaksepettelogo.png",
          "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "444 3 284",
            "contactType": "customer service",
            "contactOption": ["HearingImpairedSupported","TollFree"],
            "areaServed": "TR",
            "availableLanguage": "Turkish"
          },
          "sameAs": [
            "https://www.instagram.com/emlaksepette/",
            "https://www.facebook.com/emlaksepette"
          ]
        }
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
            background-image: linear-gradient(135deg, #e54242 5.77%, #fff 5.77%, #fff 25%, #111 25%, #111 30.77%, #fff 30.77%, #fff 50%, #e54242 50%, #e54242 55.77%, #fff 55.77%, #fff 75%, #111 75%, #111 80.77%, #fff 80.77%, #fff 100%);
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
    </style>
@endsection
