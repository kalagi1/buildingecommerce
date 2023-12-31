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
            <p>2023 © Copyright - All Rights Reserved. @innovaticacode</p>
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

<script>
    $(document).ready(function() {
        checkFavorites();
        var cart = @json(session('cart', []));
        console.log(cart);
        // Sayfa yüklendiğinde düğme metnini güncellemek için bir işlev çağırın
        updateCartButton();

        // Tüm "Sepete Ekle" düğmelerini seçin
        var addToCartButtons = document.querySelectorAll(".addToCart");

        // Her düğmeye tıklanma olayını dinleyin
        addToCartButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var productId = button.getAttribute("data-id");

                // Sepete ekleme işlemi burada yapılmalıdır

                // Ajax isteği gönderme
                var cart = {
                    id: productId,
                    type: button.getAttribute("data-type"),
                    _token: "{{ csrf_token() }}",
                    clear_cart: "no" // Varsayılan olarak sepeti temizleme işlemi yok
                };

                // Eğer kullanıcı zaten ürün eklediyse ve yeni bir ürün eklenmek isteniyorsa sepeti temizlemeyi sorgula
                if (!isProductInCart(productId)) {
                    var confirmClearCart = confirm("Mevcut sepeti temizlemek istiyor musunuz?");
                    if (confirmClearCart) {
                        cart.clear_cart = "yes"; // Kullanıcı sepeti temizlemeyi onayladı
                    }
                }

                $.ajax({
                    url: "{{ route('add.to.cart') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                    type: "POST", // Veriyi göndermek için POST kullanabilirsiniz
                    data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                    success: function(response) {
                        toastr.success("Ürün Sepete Eklendi");
                        button.classList.add("bg-success");

                        // Ürün sepete eklendiğinde düğme metnini ve durumunu güncelleyin
                        button.textContent = "Sepete Eklendi";
                        button.disabled = true;

                        // Eğer sepeti temizlemeyi onayladıysa sayfayı yeniden yükle
                        if (cart.clear_cart === "yes") {
                            location.reload();
                        }
                    },
                    error: function(error) {
                        toastr.error("Hata oluştu: " + error.responseText, "Hata");
                        console.error("Hata oluştu: " + error);
                    }
                });
            });
        });

        function updateCartButton() {
            // Tüm "Sepete Ekle" düğmelerini seçin
            var addToCartButtons = document.querySelectorAll(".addToCart");
            addToCartButtons.forEach(function(button) {
                var productId = button.getAttribute("data-id");

                if (isProductInCart(productId)) {
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

        function isProductInCart(productId) {
            // Sepet içeriğini session'dan alın
            var cart = @json(session('cart', []));
            if (cart.length != 0) {
                if (cart.item.id == productId) {
                    return true; // Ürün sepette bulundu

                }
            }
            return false; // Ürün sepette bulunamadı
        }


        function checkFavorites() {
            // Favorileri sorgula ve uygun renk ve ikonları ayarla
            var favoriteButtons = document.querySelectorAll(".toggle-favorite");

            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-housing-id");

                // AJAX isteği gönderme
                $.ajax({
                    url: "{{ route('get.housing.favorite.status', ['id' => ':id']) }}"
                        .replace(':id', housingId),
                    type: "GET",
                    success: function(response) {
                        console.log(response);
                        if (response.is_favorite) {
                            button.querySelector("i.fa-heart").classList.add("text-danger");
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


        // Favoriye Ekle/Kaldır İşlemi
        document.querySelectorAll(".toggle-favorite").forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();
                var housingId = this.getAttribute("data-housing-id");

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
                            toastr.success("Ürün Favorilere Eklendi");
                            // Favorilere eklenmişse rengi kırmızı yap
                            button.querySelector("i.fa-heart").classList.add(
                                "text-danger");
                            button.classList.add(
                                "bg-white");
                        } else if (response.status === 'removed') {
                            toastr.warning("Ürün Favorilerden Kaldırıldı");
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

        $("#addToCart").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz
            var cart = {
                id: $(this).data('id'),
                type: $(this).data('type'),

                _token: "{{ csrf_token() }}"
            };

            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('add.to.cart') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart, // Sepete eklemek istediğiniz ürün verilerini gönderin
                success: function(response) {
                    // İşlem başarılı olduğunda buraya gelir
                    toast.success(response)
                    console.log("Ürün sepete eklendi: " + response);
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        });
    });
</script>
@yield('scripts')
</div>
<!-- Wrapper / End -->

</body>



</html>
