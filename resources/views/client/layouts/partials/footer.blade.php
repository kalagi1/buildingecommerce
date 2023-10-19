<footer class="first-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg col-xl">
                    <div class="netabout">
                        <a href="index.html" class="logo">
                            <img src="{{ URL::to('/') }}/images/logo.png" alt="netcom">
                        </a>
                    </div>

                </div>
                @foreach ($widgetGroups as $widgetGroup)
                    <div class="col-sm-6 col-md-6 col-lg col-xl">
                        <div class="navigation">
                            <h3>{{ $widgetGroup->widget }}</h3>
                            <div class="nav-footer">
                                <ul>
                                    @foreach ($footerLinks as $footerLink)
                                        @if ($footerLink->widget === $widgetGroup->widget)
                                            <li><a href="{{ $footerLink->url }}">{!! $footerLink->title !!}</a></li>
                                        @endif
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

<!--register form -->
<div class="login-and-register-form modal">
    <div class="main-overlay"></div>
    <div class="main-register-holder">
        <div class="main-register fl-wrap">
            <div class="close-reg"><i class="fa fa-times"></i></div>
            <h3>Welcome to <span>Find<strong>Houses</strong></span></h3>
            <div class="soc-log fl-wrap">
                <p>Login</p>
                <a href="#" class="facebook-log"><i class="fa fa-facebook-official"></i>Log in with Facebook</a>
                <a href="#" class="twitter-log"><i class="fa fa-twitter"></i> Log in with Twitter</a>
            </div>
            <div class="log-separator fl-wrap"><span>Or</span></div>
            <div id="tabs-container">
                <ul class="tabs-menu">
                    <li class="current"><a href="#tab-1">Login</a></li>
                    <li><a href="#tab-2">Register</a></li>
                </ul>
                <div class="tab">
                    <div id="tab-1" class="tab-contents">
                        <div class="custom-form">
                            <form method="post" name="registerform">
                                <label>Username or Email Address * </label>
                                <input name="email" type="text" onClick="this.select()" value="">
                                <label>Password * </label>
                                <input name="password" type="password" onClick="this.select()" value="">
                                <button type="submit" class="log-submit-btn"><span>Log In</span></button>
                                <div class="clearfix"></div>
                                <div class="filter-tags">
                                    <input id="check-a" type="checkbox" name="check">
                                    <label for="check-a">Remember me</label>
                                </div>
                            </form>
                            <div class="lost_password">
                                <a href="#">Lost Your Password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="tab">
                        <div id="tab-2" class="tab-contents">
                            <div class="custom-form">
                                <form method="post" name="registerform" class="main-register-form"
                                    id="main-register-form2">
                                    <label>First Name * </label>
                                    <input name="name" type="text" onClick="this.select()" value="">
                                    <label>Second Name *</label>
                                    <input name="name2" type="text" onClick="this.select()" value="">
                                    <label>Email Address *</label>
                                    <input name="email" type="text" onClick="this.select()" value="">
                                    <label>Password *</label>
                                    <input name="password" type="password" onClick="this.select()" value="">
                                    <button type="submit" class="log-submit-btn"><span>Register</span></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--register form end -->

<!-- START PRELOADER -->
<div id="preloader">
    <div id="status">
        <div class="status-mes"></div>
    </div>
</div>
<!-- END PRELOADER -->

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
                if (!isProductInCart(productId)) {
                    // Kullanıcıya onay için bir onay kutusu göster
                    Swal.fire({
                        title: 'Mevcut sepeti temizlemek istiyor musunuz?',
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
                                    button.textContent = "Sepete Eklendi";
                                    button.disabled = true;

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
            }
        });


        updateCartButton();

        function updateCartButton() {
            var addToCartButtons = document.querySelectorAll(".addToCart");

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
                    button.disabled = true;
                } else {
                    button.textContent = "Sepete Ekle";
                    button.classList.remove("bg-success");
                    button.disabled = false;
                }
            });
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
</script>




@yield('scripts')

</div>
<!-- Wrapper / End -->

</body>



</html>
