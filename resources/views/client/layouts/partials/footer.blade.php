<footer class="first-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg col-xl">
                    <div class="netabout">
                        <a href="index.html" class="logo">
                            <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="netcom">
                        </a>
                    </div>

                </div>
                @foreach ($widgetGroups as $widgetGroup)
                    <div class="col-sm-6 col-md-6 col-lg col-6">
                        <div class="navigation">
                            <h3>{{ $widgetGroup->widget }}</h3>
                            <div class="nav-footer">
                                <ul>
                                    @foreach ($footerLinks as $footerLink)
                                        @if ($footerLink->widget === $widgetGroup->widget)
                                            <li><a href="{{ $footerLink->url }}">{!! $footerLink->title !!}</a></li>
                                        @endif
                                    @endforeach
                                    @foreach (App\Models\Page::where('widget', $widgetGroup->widget)->get() as $p)
                                        <li><a href="{{ $p->slug }}">{{ $p->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="second-footer bg-white-3">
        <div class="container">
            <p class="d-flex align-items-center" style="gap: 16px;">
                <span>2023 © Copyright - All Rights Reserved. @innovaticacode</span>
                @foreach ($fl as $link)
                    <a href="{{ url('sayfa/' . $link->slug) }}" style="color: white;">{{ $link->meta_title }}</a>
                @endforeach
            </p>
            <ul class="netsocials">
                @foreach ($socialMediaIcons as $icon)
                    <li><a href="{{ $icon->url }}"><i class="{{ $icon->icon_class }}" aria-hidden="true"></i></a>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</footer>

<a data-scroll href="#wrapper" class="go-up"><i class="fa fa-angle-double-up" aria-hidden="true"></i></a>
<!-- END FOOTER -->

<style>
    .button-container {
        display: none;
    }

    @media (max-width: 768px) {
        .button-container {
            z-index: 9999999;
            position: fixed;
            width: 100%;
            bottom: 0;
            display: flex;
            background-color: #F7F7F7;
            height: 70px;
            align-items: center;
            justify-content: space-around;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px,
                rgba(245, 73, 144, 0.5) 5px 10px 15px;
        }

        .button-container .button {
            outline: 0 !important;
            border: 0 !important;
            padding: 0 !important;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            color: black;
            transition: all ease-in-out 0.3s;
            cursor: pointer;
            flex-direction: column;

        }

        .button-container .button span {
            margin-top: 5px;
            font-size: 13px
        }

        .button-container .button:hover {
            transform: translateY(-3px);
        }

        .button-container .icon {
            font-size: 20px;
        }
    }
</style>

<div class="button-container">

    <a href="{{ Auth::check() ? (Auth::user()->type == 1 ? route('client.index') : (Auth::user()->type == 2 ? route('institutional.index') : (Auth::user()->type == 3 ? route('admin.index') : route('client.login')))) : route('client.login') }}"
        class="button">
        <button class="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1024 1024"
                stroke-width="0" fill="currentColor" stroke="currentColor" class="icon">
                <path
                    d="M946.5 505L560.1 118.8l-25.9-25.9a31.5 31.5 0 0 0-44.4 0L77.5 505a63.9 63.9 0 0 0-18.8 46c.4 35.2 29.7 63.3 64.9 63.3h42.5V940h691.8V614.3h43.4c17.1 0 33.2-6.7 45.3-18.8a63.6 63.6 0 0 0 18.7-45.3c0-17-6.7-33.1-18.8-45.2zM568 868H456V664h112v204zm217.9-325.7V868H632V640c0-22.1-17.9-40-40-40H432c-22.1 0-40 17.9-40 40v228H238.1V542.3h-96l370-369.7 23.1 23.1L882 542.3h-96.1z">
                </path>
            </svg>
            @if (Auth::check())
                <span>Hesabım</span>
            @else
                <span>Giriş Yap</span>
            @endif
        </button>
    </a>

    <a href="{{ Auth::check() ? route('favorites') : route('client.login') }}" class="button">
        <button class="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" aria-hidden="true" viewBox="0 0 24 24"
                stroke-width="2" fill="none" stroke="currentColor" class="icon">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg>
            <span>Favorilerim</span>
        </button>
    </a>


    <a href="{{ Auth::check() ? (Auth::user()->type == 1 ? route('client.index') : (Auth::user()->type == 2 ? url('institutional/create_project_v2') : (Auth::user()->type == 3 ? 'javascript:void(0)' : 'javascript:void(0)'))) : route('client.login') }}"
        class="button" class="{{ Auth::check() ? (Auth::user()->type != 3 ? 'd-block' : 'd-none') : '' }}">
        <button class="button">
            <svg viewBox="0 0 24 24" width="1em" height="1em" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="icon">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            @if (Auth::check() && Auth::user()->type == 2)
                <span>İlan Ver</span>
            @else
                <span>Sat Kirala</span>
            @endif
        </button>
    </a>

    <a href="{{ route('cart') }}" class="button"
        class="{{ Auth::check() ? (Auth::user()->type != 3 ? 'd-block' : 'd-none') : '' }}">
        <button class="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round"
                stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor"
                class="icon">
                <circle r="1" cy="21" cx="9"></circle>
                <circle r="1" cy="21" cx="20"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span>Sepetim</span>
        </button>
    </a>

</div>

<!-- ARCHIVES JS -->
<script src="{{ URL::to('/') }}/js/jquery-3.5.1.min.js"></script>
<script src="{{ URL::to('/') }}/js/rangeSlider.js"></script>
<script src="{{ URL::to('/') }}/js/tether.min.js"></script>
<script src="{{ URL::to('/') }}/js/moment.js"></script>
<script src="{{ URL::to('/') }}/js/bootstrap.min.js"></script>
<script src="{{ URL::to('/') }}/js/mmenu.min.js"></script>
<script src="{{ URL::to('/') }}/js/mmenu.js"></script>
<script src="{{ URL::to('/') }}/js/aos.js"></script>
<script src="{{ URL::to('/') }}/js/aos2.js"></script>
<script src="{{ URL::to('/') }}/js/slick.min.js"></script>
<script src="{{ URL::to('/') }}/js/fitvids.js"></script>
<script src="{{ URL::to('/') }}/js/jquery.waypoints.min.js"></script>
<script src="{{ URL::to('/') }}/js/jquery.counterup.min.js"></script>
<script src="{{ URL::to('/') }}/js/imagesloaded.pkgd.min.js"></script>
<script src="{{ URL::to('/') }}/js/isotope.pkgd.min.js"></script>
<script src="{{ URL::to('/') }}/js/smooth-scroll.min.js"></script>
<script src="{{ URL::to('/') }}/js/lightcase.js"></script>
<script src="{{ URL::to('/') }}/js/search.js"></script>
<script src="{{ URL::to('/') }}/js/owl.carousel.js"></script>
<script src="{{ URL::to('/') }}/js/jquery.magnific-popup.min.js"></script>
<script src="{{ URL::to('/') }}/js/ajaxchimp.min.js"></script>
<script src="{{ URL::to('/') }}/js/newsletter.js"></script>
<script src="{{ URL::to('/') }}/js/jquery.form.js"></script>
<script src="{{ URL::to('/') }}/js/jquery.validate.min.js"></script>
<script src="{{ URL::to('/') }}/js/searched.js"></script>
<script src="{{ URL::to('/') }}/js/forms-2.js"></script>
<script src="{{ URL::to('/') }}/js/range.js"></script>
<script src="{{ URL::to('/') }}/js/color-switcher.js"></script>

<script>
    $(document).ready(function() {
        const searchInput = $(".search-input");
        const suggestions = $(".header-search__suggestions");
        searchInput.attr("autocomplete", "off");

        // Arama alanına tıklama olayını ekle
        searchInput.click(function() {

            suggestions.show();
        });

        // Sayfa herhangi bir yerine tıklama olayını ekle
        $(document).click(function(event) {
            if (!searchInput.is(event.target) && !suggestions.is(event.target)) {
                suggestions.hide();
            }
        });
    });
    $('.slick-agents').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        dots: false,
        loop: true,
        autoplay: true,
        arrows: true,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }, {
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
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }]
    });

    $('.slick-agents-2').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: false,
        arrows: true,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: false,
                arrows: false
            }
        }, {
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
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }]
    });
    $('.slick-agentsc').slick({
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 993,
            settings: {
                slidesToShow: 5,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 769,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                arrows: true
            }
        }]
    });
</script>
<script>
    $('.slick-lancers').slick({
        infinite: false,
        slidesToShow: 12.5,
        slidesToScroll: 5,
        dots: false,
        arrows: false,
        adaptiveHeight: true,
        responsive: [{
            breakpoint: 1292,
            settings: {
                slidesToShow: 10,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 993,
            settings: {
                slidesToShow: 8,
                slidesToScroll: 3,
                dots: false,
                arrows: false
            }
        }, {
            breakpoint: 769,
            settings: {
                slidesToShow: 5.5,
                slidesToScroll: 1,
                dots: false,
                arrows: false
            }
        }]
    });
</script>


<script>
    $('.home5-right-slider').owlCarousel({
        loop: true,
        margin: 30,
        dots: false,
        nav: true,
        rtl: false,
        autoplayHoverPause: false,
        autoplay: false,
        singleItem: true,
        smartSpeed: 1200,
        navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1,
                center: false
            },
            480: {
                items: 1,
                center: false
            },
            520: {
                items: 1,
                center: false
            },
            600: {
                items: 1,
                center: false
            },
            768: {
                items: 2
            },
            992: {
                items: 1
            },
            1200: {
                items: 1
            },
            1366: {
                items: 1
            },
            1400: {
                items: 1
            }
        }
    });
</script>
<script>
    $(".dropdown-filter").on('click', function() {

        $(".explore__form-checkbox-list").toggleClass("filter-block");

    });
</script>

<!-- Slider Revolution scripts -->
<script src="{{ URL::to('/') }}/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="{{ URL::to('/') }}/revolution/js/jquery.themepunch.revolution.min.js"></script>

<!-- MAIN JS -->
<script src="{{ URL::to('/') }}/js/script.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">

<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>

<script>
    $(document).ready(function() {
        checkFavorites();
        checkProjectFavorites();
        var cart = @json(session('cart', []));
        // Sayfa yüklendiğinde düğme metnini güncellemek için bir işlev çağırın

        // Tüm "Sepete Ekle" düğmelerini seçin
        var addToCartButtons = document.querySelectorAll(".addToCart");
        // Tüm "Sepete Ekle" düğmelerini seçin (dinamik olarak oluşturulanlar dahil)
        $('body').on('click', '.addToCart', function(event) {
            event.preventDefault();
            if (event.target && event.target.classList.contains('addToCart')) {
                var button = event.target;
                var productId = button.getAttribute("data-id");

                var project = null;
                if (button.getAttribute("data-type") == "project") {
                    project = button.getAttribute("data-project");
                    // Ajax isteği gönderme
                    var cart = {
                        id: productId,
                        type: button.getAttribute("data-type"),
                        project: project,
                        _token: "{{ csrf_token() }}",
                        clear_cart: "no" // Varsayılan olarak sepeti temizleme işlemi yok
                    };
                } else {
                    var cart = {
                        id: productId,
                        type: button.getAttribute("data-type"),
                        _token: "{{ csrf_token() }}",
                        clear_cart: "no" // Varsayılan olarak sepeti temizleme işlemi yok
                    };
                }

                // Eğer kullanıcı zaten ürün eklediyse ve yeni bir ürün eklenmek isteniyorsa sepeti temizlemeyi sorgula
                // Kullanıcıya onay için bir onay kutusu göster
                Swal.fire({
                    title: isCartEmpty() ? 'Sepete eklemek istiyor musunuz?' :
                        'Mevcut sepeti temizlemek istiyor musunuz?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, temizle',
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        cart.clear_cart = "yes"; // Kullanıcı sepeti temizlemeyi onayladı
                        // Ajax isteğini gönder
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "{{ route('add.to.cart') }}", true);
                        xhr.setRequestHeader("Content-Type",
                            "application/json;charset=UTF-8");
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                console.log(xhr.responseText);
                                toastr.success("Ürün Sepete Eklendi");
                                button.classList.add("bg-success");

                                // Ürün sepete eklendiğinde düğme metnini ve durumunu güncelleyin
                                if (!button.classList.contains("mobile"))
                                    button.textContent = "Sepete Eklendi";

                                // Eğer sepeti temizlemeyi onayladıysa sayfayı yeniden yükle
                                if (cart.clear_cart === "yes") {
                                    location.reload();
                                }
                            } else {
                                toastr.error("Hata oluştu: " + xhr.responseText,
                                    "Hata");
                                console.error("Hata oluştu: " + xhr.responseText);
                            }
                        };
                        xhr.onerror = function() {
                            toastr.error("Hata oluştu: İstek gönderilemedi", "Hata");
                            console.error("Hata oluştu: İstek gönderilemedi");
                        };
                        xhr.send(JSON.stringify(cart));
                    }
                });
            }
        });

        var addToCartButtons = document.querySelectorAll(".CartBtn");
        // Tüm "Sepete Ekle" düğmelerini seçin (dinamik olarak oluşturulanlar dahil)
        $('body').on('click', '.CartBtn', function(event) {
            event.preventDefault();
            if (event.target && event.target.classList.contains('CartBtn')) {
                var button = event.target;
                var productId = button.getAttribute("data-id");

                var project = null;
                if (button.getAttribute("data-type") == "project") {
                    project = button.getAttribute("data-project");
                    // Ajax isteği gönderme
                    var cart = {
                        id: productId,
                        type: button.getAttribute("data-type"),
                        project: project,
                        _token: "{{ csrf_token() }}",
                        clear_cart: "no" // Varsayılan olarak sepeti temizleme işlemi yok
                    };
                } else {
                    var cart = {
                        id: productId,
                        type: button.getAttribute("data-type"),
                        _token: "{{ csrf_token() }}",
                        clear_cart: "no" // Varsayılan olarak sepeti temizleme işlemi yok
                    };
                }

                // Eğer kullanıcı zaten ürün eklediyse ve yeni bir ürün eklenmek isteniyorsa sepeti temizlemeyi sorgula
                // Kullanıcıya onay için bir onay kutusu göster
                Swal.fire({
                    title: isCartEmpty() ? 'Sepete eklemek istiyor musunuz?' :
                        'Mevcut sepeti temizlemek istiyor musunuz?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Evet, temizle',
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        cart.clear_cart = "yes"; // Kullanıcı sepeti temizlemeyi onayladı
                        // Ajax isteğini gönder
                        var xhr = new XMLHttpRequest();
                        xhr.open("POST", "{{ route('add.to.cart') }}", true);
                        xhr.setRequestHeader("Content-Type",
                            "application/json;charset=UTF-8");
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                console.log(xhr.responseText);
                                toastr.success(isCartEmpty() ?
                                    'Ürün Sepete Eklendi' :
                                    'Ürün Sepetten Çıkarıldı');
                                button.classList.add("bg-success");

                                // Ürün sepete eklendiğinde düğme metnini ve durumunu güncelleyin
                                if (!button.classList.contains("mobile"))
                                    button.querySelector(".text").textContent =
                                    "Sepete Eklendi";

                                // Eğer sepeti temizlemeyi onayladıysa sayfayı yeniden yükle
                                if (cart.clear_cart === "yes") {
                                    location.reload();
                                }
                            } else {
                                toastr.error("Hata oluştu: " + xhr.responseText,
                                    "Hata");
                                console.error("Hata oluştu: " + xhr.responseText);
                            }
                        };
                        xhr.onerror = function() {
                            toastr.error("Hata oluştu: İstek gönderilemedi", "Hata");
                            console.error("Hata oluştu: İstek gönderilemedi");
                        };
                        xhr.send(JSON.stringify(cart));
                    }
                });
            }
        });


        updateCartButton();

        function updateCartButton() {
            var addToCartButtons = document.querySelectorAll(".addToCart:not(.mobile)");

            addToCartButtons.forEach(function(button) {
                var productId = button.getAttribute("data-id");
                var productType = button.getAttribute("data-type");
                var product = null;
                if (productType == "project") {
                    product = button.getAttribute("data-project");
                }

                if (isProductInCart(productId, product)) {
                    button.textContent = "Sepete Eklendi";
                    button.classList.add("bg-success");
                } else {
                    button.textContent = "Sepete Ekle";
                    button.classList.remove("bg-success");
                }
            });

            var CartBtn = document.querySelectorAll(".CartBtn:not(.mobile)");

            CartBtn.forEach(function(button) {
                var productId = button.getAttribute("data-id");
                var productType = button.getAttribute("data-type");
                var product = null;
                if (productType == "project") {
                    product = button.getAttribute("data-project");
                }

                if (isProductInCart(productId, product)) {
                    button.querySelector(".text").textContent = "Sepete Eklendi";
                    button.classList.add("bg-success");
                } else {
                    button.querySelector(".text").textContent = "Sepete Ekle";
                    button.classList.remove("bg-success");
                }
            });
        }

        function isCartEmpty() {
            var cart = @json(session('cart', []));
            return cart.length <= 0;
        }

        function isProductInCart(productId, product) {
            var cart = @json(session('cart', []));
            if (cart.length != 0) {
                if (product != null) {
                    if (cart.item.id == product && cart.item.housing == productId) {
                        return true;
                    }
                } else {
                    if (cart.item.id == productId) {
                        return true; // Ürün sepette bulundu
                    }
                }
            }
            return false; // Ürün sepette bulunamadı
        }

        function checkProjectFavorites() {
            // Favorileri sorgula ve uygun renk ve ikonları ayarla
            var favoriteButtons = document.querySelectorAll(".toggle-project-favorite");

            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-project-housing-id");
                var projectId = button.getAttribute("data-project-id");

                // AJAX isteği gönderme
                $.ajax({
                    url: "{{ route('get.project.housing.favorite.status', ['id' => ':id', 'projectId' => ':projectId']) }}"
                        .replace(':id', housingId)
                        .replace(':projectId', projectId), // Proje ID'sini de iletiyoruz
                    type: "GET",
                    success: function(response) {
                        if (response.is_favorite) {
                            button.querySelector("i.fa-heart").classList.add(
                                "text-danger");
                            button.classList.add("bg-white");
                        } else {
                            button.querySelector("i.fa-heart").classList.remove(
                                "text-danger");
                            button.classList.remove("bg-white");
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        }

        function checkFavorites() {
            // Favorileri sorgula ve uygun renk ve ikonları ayarla
            var favoriteButtons = document.querySelectorAll(".toggle-favorite");

            document.addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('toggle-favorite')) {
                    var button = event.target;
                    var housingId = button.getAttribute("data-housing-id");

                    // AJAX isteği gönderme
                    $.ajax({
                        url: "{{ route('get.housing.favorite.status', ['id' => ':id']) }}"
                            .replace(':id', housingId),
                        type: "GET",
                        success: function(response) {
                            if (response.is_favorite) {
                                button.querySelector("i.fa-heart").classList.add(
                                    "text-danger");
                                button.classList.add("bg-white");
                            } else {
                                button.querySelector("i.fa-heart").classList.remove(
                                    "text-danger");
                                button.classList.remove("bg-white");
                            }
                        },
                        error: function(error) {
                            console.error(error);
                        }
                    });
                }
            });
        }

        // Favoriye Ekle/Kaldır İşlemi
        document.querySelectorAll(".toggle-project-favorite").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                var housingId = this.getAttribute("data-project-housing-id");
                var projectId = this.getAttribute("data-project-id");

                // AJAX isteği gönderme
                $.ajax({
                    url: "{{ route('add.project.housing.to.favorites', ['id' => ':id']) }}"
                        .replace(':id',
                            housingId),
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        project_id: projectId // project_id'yi AJAX isteği ile gönder
                    },
                    success: function(response) {
                        if (response.status === 'added') {
                            toastr.success("Konut Favorilere Eklendi");
                            // Favorilere eklenmişse rengi kırmızı yap
                            button.querySelector("i.fa-heart").classList.add(
                                "text-danger");
                            button.classList.add(
                                "bg-white");
                        } else if (response.status === 'removed') {
                            toastr.warning("Konut Favorilerden Kaldırıldı");
                            button.querySelector("i.fa-heart").classList.remove(
                                "text-danger");
                            button.classList.remove(
                                "bg-white");
                        }
                    },
                    error: function(error) {
                        toastr.error("Lütfen Giriş Yapınız");
                        console.error(error);
                    }
                });
            });
        });

        // Favoriye Ekle/Kaldır İşlemi
        $('body').on("click", ".toggle-favorite", function(event) {
            event.preventDefault();
            var housingId = this.getAttribute("data-housing-id");
            var button = this;
            // AJAX isteği gönderme
            $.ajax({
                url: "{{ route('add.housing.to.favorites', ['id' => ':id']) }}"
                    .replace(':id',
                        housingId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status === 'added') {
                        toastr.success("Konut Favorilere Eklendi");
                        // Favorilere eklenmişse rengi kırmızı yap
                        button.querySelector("i.fa-heart").classList.add(
                            "text-danger");
                        button.classList.add(
                            "bg-white");
                    } else if (response.status === 'removed') {
                        toastr.warning("Konut Favorilerden Kaldırıldı");
                        button.querySelector("i.fa-heart").classList.remove(
                            "text-danger");
                        button.classList.remove(
                            "bg-white");
                    }
                },
                error: function(error) {
                    toastr.error("Lütfen Giriş Yapınız");
                    console.error(error);
                }
            });
        });

    });
</script>

<script>
    'use strict';
    $(function() {
        const appUrl = "http://127.0.0.1:8000/"; // Uygulama URL'si
        let timeout; // AJAX isteği için zamanlayıcı değişkeni

        function showSearchingMessage() {
            $('.header-search-box').empty().append(
                '<div class="font-weight-bold p-2 small" style="background-color: #EEE;">Aranıyor...</div>');
        }

        function hideSearchingMessage() {
            $('.header-search-box div:contains("Aranıyor...")').remove();
        }

        function drawHeaderSearchbox(searchTerm) {
            showSearchingMessage();

            if (timeout) {
                clearTimeout(timeout); // Önceki AJAX isteğini iptal et
            }

            timeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('get-search-list') }}",
                    method: "GET",
                    data: {
                        searchTerm
                    },
                    success: function(data) {
                        let hasResults = false;

                        // Housing search
                        if (data.housings.length > 0) {
                            hasResults = true;
                            $('.header-search-box').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">KONUTLAR</div>
                            `);
                            console.log(data.housings);
                            data.housings.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}housing_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin

                                $('.header-search-box').append(`
    <a href="{{ route('housing.show', '') }}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
        <img src="${imageUrl}" width="48" height="48" class="rounded-sm"/>
        <span>${e.name}</span>
    </a>
`);

                            });
                        }

                        // Project search
                        if (data.projects.length > 0) {
                            hasResults = true;
                            $('.header-search-box').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">PROJELER</div>
                            `);
                            console.log(data.projects);
                            data.projects.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}${e.photo.replace('public', 'storage')}`; // Resim URL'sini uygulama URL'si ile birleştirin

                                $('.header-search-box').append(`
                                    <a  href="{{ route('project.detail', '') }}/${e.slug}"  class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                        <img src="${imageUrl}" width="48" height="48" class="rounded-sm"/>
                                        <span>${e.name}</span>
                                    </a>
                                `);
                            });
                        }

                        // Merchant search
                        if (data.merchants.length > 0) {
                            hasResults = true;
                            $('.header-search-box').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">MAĞAZALAR</div>
                            `);
                            data.merchants.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}storage/profile_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin

                                $('.header-search-box').append(`
                                    <a href="{{ route('instituional.dashboard', '') }}/${e.slug}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                        <img src="${imageUrl}" width="48" height="48" class="rounded-sm"/>
                                        <span>${e.name}</span>
                                    </a>
                                `);
                            });
                        }

                        // Veri yoksa veya herhangi bir sonuç yoksa "Sonuç Bulunamadı" mesajını görüntüle
                        if (!hasResults) {
                            $('.header-search-box').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: white; text-align: center;">Sonuç bulunamadı</div>
                            `);
                        } else {
                            hideSearchingMessage
                                (); // AJAX başarılı olduğunda "Aranıyor..." yazısını kaldır
                        }

                        if ($('.header-search-box').children().length > 3) {
                            $('.header-search-box').css('overflow-y',
                                'scroll'
                            ); // 7'den fazla sonuç varsa kaydırma çubuğunu etkinleştir
                        } else {
                            $('.header-search-box').css('overflow-y',
                                'unset'
                            ); // 7 veya daha az sonuç varsa kaydırma çubuğunu devre dışı bırak
                        }
                    }
                });
            }, 1000); // 1 saniye gecikmeli AJAX isteği başlat
        }

        $('#ss-box').on('input', function() {
            let term = $(this).val();

            if (term != '') {
                $('.header-search-box').addClass('d-flex').removeClass('d-none');
                drawHeaderSearchbox(term);
            } else {
                $('.header-search-box').removeClass('d-flex').addClass('d-none');
            }
        });
    });


    $(document).click(function(event) {
        if (
            $('.toggle > input').is(':checked') &&
            !$(event.target).parents('.toggle').is('.toggle')
        ) {
            $('.toggle > input').prop('checked', false);
        }
    })
</script>


<script>
    'use strict';
    $(function() {
        const appUrl = "http://127.0.0.1:8000/"; // Uygulama URL'si
        let timeout; // AJAX isteği için zamanlayıcı değişkeni

        function showSearchingMessage() {
            $('.header-search-box-mobile').empty().append(
                '<div class="font-weight-bold p-2 small" style="background-color: #EEE;">Aranıyor...</div>');
        }

        function hideSearchingMessage() {
            $('.header-search-box-mobile div:contains("Aranıyor...")').remove();
        }

        function drawHeaderSearchbox(searchTerm) {
            showSearchingMessage();

            if (timeout) {
                clearTimeout(timeout); // Önceki AJAX isteğini iptal et
            }

            timeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('get-search-list') }}",
                    method: "GET",
                    data: {
                        searchTerm
                    },
                    success: function(data) {
                        let hasResults = false;

                        // Housing search
                        if (data.housings.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">KONUTLAR</div>
                            `);
                            console.log(data.housings);
                            data.housings.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}housing_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin

                                $('.header-search-box-mobile').append(`
    <a href="{{ route('housing.show', '') }}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
        <img src="${imageUrl}" width="48" height="48" class="rounded-sm"/>
        <span>${e.name}</span>
    </a>
`);

                            });
                        }

                        // Project search
                        if (data.projects.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">PROJELER</div>
                            `);
                            console.log(data.projects);
                            data.projects.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}${e.photo.replace('public', 'storage')}`; // Resim URL'sini uygulama URL'si ile birleştirin

                                $('.header-search-box-mobile').append(`
                                    <a  href="{{ route('project.detail', '') }}/${e.slug}"  class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                        <img src="${imageUrl}" width="48" height="48" class="rounded-sm"/>
                                        <span>${e.name}</span>
                                    </a>
                                `);
                            });
                        }

                        // Merchant search
                        if (data.merchants.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">MAĞAZALAR</div>
                            `);
                            data.merchants.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}storage/profile_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin

                                $('.header-search-box-mobile').append(`
                                    <a href="{{ route('instituional.dashboard', '') }}/${e.slug}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                        <img src="${imageUrl}" width="48" height="48" class="rounded-sm"/>
                                        <span>${e.name}</span>
                                    </a>
                                `);
                            });
                        }

                        // Veri yoksa veya herhangi bir sonuç yoksa "Sonuç Bulunamadı" mesajını görüntüle
                        if (!hasResults) {
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: white; text-align: center;">Sonuç bulunamadı</div>
                            `);
                        } else {
                            hideSearchingMessage
                                (); // AJAX başarılı olduğunda "Aranıyor..." yazısını kaldır
                        }

                        if ($('.header-search-box-mobile').children().length > 3) {
                            $('.header-search-box-mobile').css('overflow-y',
                                'scroll'
                            ); // 7'den fazla sonuç varsa kaydırma çubuğunu etkinleştir
                        } else {
                            $('.header-search-box-mobile').css('overflow-y',
                                'unset'
                            ); // 7 veya daha az sonuç varsa kaydırma çubuğunu devre dışı bırak
                        }
                    }
                });
            }, 1000); // 1 saniye gecikmeli AJAX isteği başlat
        }

        $('#ss-box-mobile').on('input', function() {
            let term = $(this).val();

            if (term != '') {
                $('.header-search-box-mobile').addClass('d-flex').removeClass('d-none');
                drawHeaderSearchbox(term);
            } else {
                $('.header-search-box-mobile').removeClass('d-flex').addClass('d-none');
            }
        });
    });
    $(document).ready(function() {
        $('.slick-lancersl').slick({
            loop: true,
            margin: 30,
            rtl: false,
            autoplayHoverPause: false,
            singleItem: true,
            smartSpeed: 1200,
            infinite: true,
            autoplay: true,
            loop: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
            arrows: true,
            adaptiveHeight: true,
        });
    });
</script>




@yield('scripts')

</div>
<!-- Wrapper / End -->

</body>



</html>
