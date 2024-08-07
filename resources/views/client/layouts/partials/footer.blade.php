<a id="scrollToTopBtn" class="fa fa-angle-double-up"
    style="display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    font-size: 40px;
    color: #2f5f9e;
    cursor: pointer;
    z-index: 1000;
    transition: color 0.3s;"
    onclick="scrollToTop()"></a>
<footer class="first-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg col-xl">
                    <div class="netabout">
                        <a href="{{ URL::to('/') }}" class="logo">
                            <img src="{{ URL::to('/') }}/images/emlaksepettelogo.png" alt="netcom">
                        </a>
                    </div>
                    <div id="ETBIS">
                        <div id="6701734445307742"><a
                                href="https://etbis.eticaret.gov.tr/sitedogrulama/6701734445307742" target="_blank"><img
                                    style='width:100px; height:120px'
                                    src="data:image/jpeg;base64, iVBORw0KGgoAAAANSUhEUgAAAIIAAACWCAYAAAASRFBwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAEXBSURBVHhe7Z0HvF1FtcYlICEQEoqAdBCkCSgkNGkiKIggSBHpLQgKIoRIL1KkKApKBwEhNKV3jAgESLu5NbkpJCG9995h3vrvc76Tdfadc/a5yU14vOf3+32EO23vs/eambXWrJn9FUNoCf7tb38LYObMmWHDDTdskt+tW7ck3+Omm25qUu6ggw7K54Zw3nnnNcn3fOedd5Jyn376aVh99dWTtKuuuipJK4Xzzz8/KbfuuuuGSZMm5VOX4cgjj0zyt91227BkyZIk7fbbby9cU/zud7+b5HnMnTs3fP3rX0/yTzzxxHzqMowcOTJ89atfTfJ/+9vf5lPLY968eWGzzTZL6pxwwgn51BB+8pOfFO5lBfmiMUEss9nMEoTevXsn+R4rKgg9e/ZMyk2ZMqWQduWVVyZppXDaaacVyk6YMCGfugwHHHBAksdvEP76178W6ojf/va387nFWGuttZL8Y445Jp+yDLNmzSoIwvXXX59PzcYWW2yR1FklgrDddtuF008/vVn8wQ9+UGgwSxAuv/zy8OSTTxbxd7/7XaGt9dZbLynXHEGgV9HOQw89FM4444ykHR5w+joaOcBjjz2WlKNtXkwad955Z5L/i1/8IjzxxBNJ/Z/97GeFax511FFJ/q9//esm13n88cdDp06dkvwuXbo0yf/zn/9cGLkYedL5MfJc119//aROTBDWWWedcOqppybXrJSnnHJKWHvttfWbigWBH95cVFdXq7FMQYjxuuuuS+qA3XffPUlrjiCIX/va1/I1Qrjtttua5O+222753Moxbdq0Ju3AESNGJPl1dXXR/AULFiT5r776ajR/RRgThG222Saf0jxsueWWardYEM4888x8kcrx3nvvqbHlEoRbbrklqQN4WaQdcsgh+ZQQzjnnnCZ1YvzGN74Rli5dmtS59dZbm+TvtddeSV5zMHny5LDGGms0aau+vj7J79GjR5M8euecOXOS/Ndff71J/ooyJghbbbVVWLRoUT61MiCsm2++udotLQhXXHFFOPzww0ty9OjRSbksQTj00EOTYdmToXm11VZL8pmO1Gbbtm2TNIZBpf3xj39s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" /></a>
                        </div>
                    </div>

                </div>
                @foreach ($widgetGroups as $widgetGroup)
                    <div class="col-sm-12 col-md-12 col-lg col-xl">
                        <div class="navigation">
                            <h3>{{ $widgetGroup->widget }}</h3>
                            <div class="nav-footer">
                                <ul>
                                    @foreach ($footerLinks as $footerLink)
                                        @if ($footerLink->widget == $widgetGroup->widget)
                                            <li><a href="{{ $footerLink->url }}"
                                                    target="_blank">{!! $footerLink->title !!}</a></li>
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
            <p class="d-flex align-items-center" style="gap: 5px;">
                <span id="current-year"></span> © Copyright - emlaksepette.com
            </p>

            <script>
                document.getElementById("current-year").textContent = new Date().getFullYear();
            </script>

            <ul class="netsocials">
                @foreach ($socialMediaIcons as $icon)
                    <li><a href="{{ $icon->url }}" target="_blank"><i class="{{ $icon->icon_class }}"
                                aria-hidden="true"></i></a>
                    </li>
                @endforeach
            </ul>

        </div>
    </div>
</footer>
<div class="modal fade" id="addCollectionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Koleksiyona Ekle</h3>
            </div>
            <div class="modal-body">
                <span>Koleksiyonlarınız Yükleniyor...</span>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newCollectionModal" tabindex="-1" aria-labelledby="newCollectionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="newCollectionModalLabel">Yeni Koleksiyon Ekle</h3>
            </div>
            <div class="modal-body">
                <label for="newCollectionNameInput">Yeni Koleksiyon Adı:</label>
                <input type="text" id="newCollectionNameInput" name="collection_name" class="form-control mb-3"
                    style="height: 45px !important" placeholder="Yeni Koleksiyon Adı">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                <button type="button" class="btn btn-primary" id="saveNewCollectionBtn">Kaydet</button>
            </div>
        </div>
    </div>
</div>

<div class="button-container">

    <a href="{{ Auth::check() ? (Auth::user()->type == 1 ? route('institutional.index') : (Auth::user()->type == 2 ? route('institutional.index') : (Auth::user()->type == 3 ? route('admin.index') : route('institutional.index')))) : route('client.login') }}"
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


    <a href="{{ Auth::check() ? (Auth::user()->type == 1 ? route('institutional.index') : (Auth::user()->type == 2 ? url('institutional/create_project_v2') : (Auth::user()->type == 3 ? route('real.estate.index2') : route('real.estate.index2')))) : route('client.login') }}"
        class="button" class="{{ Auth::check() ? (Auth::user()->type != 3 ? 'd-block' : 'd-none') : '' }}">
        <button class="button">
            <svg viewBox="0 0 24 24" width="1em" height="1em" stroke="currentColor" stroke-width="2"
                fill="none" stroke-linecap="round" stroke-linejoin="round" class="icon">
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

<div class="payment-plan-pop-up d-none">
    <div class="payment-plan-pop-back">

    </div>
    <div class="payment-plan-pop-content">

        <div class="my-properties">
            <div class="pop-up-top-gradient">
                <div class="left">
                    <h3>Ödeme Planı Yükleniyor...</h3>
                </div>
                <div class="close payment-plan-pop-close-icon"><span><i class="fa fa-times "></i></span></div>
            </div>
            <table class="payment-plan table">
                <div class="row align-items-center" style="width:100%;margin:0 auto">
                    <div class="col-md-12">
                        <a id="whatsappButton" class="btn btn-outline-light"><svg xmlns="http://www.w3.org/2000/svg"
                                x="0px" y="0px" width="18" height="18" viewBox="0 0 48 48">
                                <path fill="#fff"
                                    d="M4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5c5.1,0,9.8,2,13.4,5.6	C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19c0,0,0,0,0,0h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3z">
                                </path>
                                <path fill="#fff"
                                    d="M4.9,43.8c-0.1,0-0.3-0.1-0.4-0.1c-0.1-0.1-0.2-0.3-0.1-0.5L7,33.5c-1.6-2.9-2.5-6.2-2.5-9.6	C4.5,13.2,13.3,4.5,24,4.5c5.2,0,10.1,2,13.8,5.7c3.7,3.7,5.7,8.6,5.7,13.8c0,10.7-8.7,19.5-19.5,19.5c-3.2,0-6.3-0.8-9.1-2.3	L5,43.8C5,43.8,4.9,43.8,4.9,43.8z">
                                </path>
                                <path fill="#cfd8dc"
                                    d="M24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19h0c-3.2,0-6.3-0.8-9.1-2.3	L4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5 M24,43L24,43L24,43 M24,43L24,43L24,43 M24,4L24,4C13,4,4,13,4,24	c0,3.4,0.8,6.7,2.5,9.6L3.9,43c-0.1,0.3,0,0.7,0.3,1c0.2,0.2,0.4,0.3,0.7,0.3c0.1,0,0.2,0,0.3,0l9.7-2.5c2.8,1.5,6,2.2,9.2,2.2	c11,0,20-9,20-20c0-5.3-2.1-10.4-5.8-14.1C34.4,6.1,29.4,4,24,4L24,4z">
                                </path>
                                <path fill="#40c351"
                                    d="M35.2,12.8c-3-3-6.9-4.6-11.2-4.6C15.3,8.2,8.2,15.3,8.2,24c0,3,0.8,5.9,2.4,8.4L11,33l-1.6,5.8	l6-1.6l0.6,0.3c2.4,1.4,5.2,2.2,8,2.2h0c8.7,0,15.8-7.1,15.8-15.8C39.8,19.8,38.2,15.8,35.2,12.8z">
                                </path>
                                <path fill="#fff" fill-rule="evenodd"
                                    d="M19.3,16c-0.4-0.8-0.7-0.8-1.1-0.8c-0.3,0-0.6,0-0.9,0	s-0.8,0.1-1.3,0.6c-0.4,0.5-1.7,1.6-1.7,4s1.7,4.6,1.9,4.9s3.3,5.3,8.1,7.2c4,1.6,4.8,1.3,5.7,1.2c0.9-0.1,2.8-1.1,3.2-2.3	c0.4-1.1,0.4-2.1,0.3-2.3c-0.1-0.2-0.4-0.3-0.9-0.6s-2.8-1.4-3.2-1.5c-0.4-0.2-0.8-0.2-1.1,0.2c-0.3,0.5-1.2,1.5-1.5,1.9	c-0.3,0.3-0.6,0.4-1,0.1c-0.5-0.2-2-0.7-3.8-2.4c-1.4-1.3-2.4-2.8-2.6-3.3c-0.3-0.5,0-0.7,0.2-1c0.2-0.2,0.5-0.6,0.7-0.8	c0.2-0.3,0.3-0.5,0.5-0.8c0.2-0.3,0.1-0.6,0-0.8C20.6,19.3,19.7,17,19.3,16z"
                                    clip-rule="evenodd"></path>
                            </svg><span class="ml-3">Ödeme Planını Paylaş</span>
                        </a>
                    </div>
                    <div class="col-md-12">
                        @if (
                            (Auth::check() && Auth::user()->type == '2' && Auth::user()->corporate_type == 'Emlak Ofisi') ||
                                (Auth::check() && Auth::user()->type == '1'))
                            <span class="textAlert"
                                style="width: 100%;
    display: block;
    padding: 0 0 10px 0;"></span>
                        @endif
                    </div>

                </div>




                <tbody>
                    <tr>
                        <td>Peşin</td>
                        <td>1.000.000,00₺</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <tr>
                        <td>Taksitli</td>
                        <td>1.400.000,00₺</td>
                        <td>14</td>
                        <td>300.000,00₺</td>
                        <td>78.571,42₺</td>
                    </tr>
                </tbody>
            </table>


        </div>
    </div>
</div>

<!-- Bu kodu sayfanın uygun bir yerine ekleyin -->

<div class="modal fade" id="membershipPopup" tabindex="-1" aria-labelledby="membershipPopupLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="membershipPopupLabel" style="color:black;">Emlak Kulüp
                    Başvurunuz</span>
            </div>
            <div class="modal-body">

                @if (Auth::check() && Auth::user()->has_club == 2)
                    <p class="text-success">
                        Sayın {{ Auth::user()->name }}, Emlak Kulüp başvurunuz şu anda Emlak Sepette yöneticileri
                        tarafından incelenmektedir.
                        Başvurunuzun durumu hakkında size en kısa sürede bilgi verilecektir. Lütfen bekleyiniz.
                    </p>
                @elseif (Auth::check() && Auth::user()->has_club == 3)
                    <p class="text-danger">
                        Sayın {{ Auth::user()->name }}, Emlak Kulüp başvurunuz maalesef reddedilmiştir.
                        Başvurunuzun reddedilme sebepleri ile ilgili detaylı bilgi almak için lütfen Emlak Sepette ile
                        iletişime geçiniz.
                    </p>
                @elseif(Auth::check() && Auth::user()->has_club == 0)
                    <p class="text-black">
                        Emlak Kulüp başvurunuz bulunmamaktadır. Emlak Kulüp ayrıcalıklarından faydalanmak için başvuru
                        yapabilirsiniz.
                    </p>
                    <a href="{{ route('institutional.sharer.index') }}" class="btn btn-primary"
                        style="height: auto !important">Başvuru Yap</a>
                @endif

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

@include('cookie-consent::index')

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    $(".accordion li").click(function() {
        console.log("adsf");
        $(this).closest(".accordion").hasClass("one-open") ? ($(this).closest(".accordion").find("li")
                .removeClass("active"), $(this).addClass("active")) : $(this).toggleClass("active"),
            "undefined" != typeof window.mr_parallax && setTimeout(mr_parallax.windowLoad, 500)
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Çerez tercihlerinin durumunu güncelle
        function updateStatusText() {
            const checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                const statusText = checkbox.previousElementSibling;
                if (checkbox.checked) {
                    statusText.textContent = 'Etkin';
                    statusText.style.color = 'green';
                } else {
                    statusText.textContent = 'Devre Dışı';
                    statusText.style.color = 'gray';
                }
            });
        }

        // Sayfa yüklendiğinde durumları güncelle
        updateStatusText();

        // Checkbox durumunu değiştirdiğinde metni güncelle
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', updateStatusText);
        });

        // Modal kapama butonu işlevi
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('cookie-management-modal').classList.add('hidden');
        });
    });
</script>

<style>
    .accordion {
        list-style-type: none;
        padding: 0;
    }

    .accordion li {
        border-bottom: 1px solid #ddd;
    }

    .accordion .title {
        cursor: pointer;
        padding: 10px;
        font-weight: bold;
    }

    .accordion .content {
        padding: 10px;
        display: none;
    }

    .accordion .active .content {
        display: block;
    }
</style>

<!-- ARCHIVES JS -->
<script src="{{ URL::to('/') }}/js/rangeSlider.js?v=2"></script>
<script src="https://cdn.jsdelivr.net/npm/tether@2.0.0/dist/js/tether.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"
    integrity="sha512-hUhvpC5f8cgc04OZb55j0KNGh4eh7dLxd/dPSJ5VyzqDWxsayYbojWyl5Tkcgrmb/RVKCRJI1jNlRbVP4WWC4w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js"
    integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/mmenu.min.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/mmenu.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"
    integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/aos2.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"
    integrity="sha512-HGOnQO9+SP1V92SrtZfjqxxtLmVzqZpjFFekvzZVWoiASSQgSr4cw9Kqd2+l8Llp4Gm0G8GIFJ4ddwZilcdb8A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fitvids/1.2.0/jquery.fitvids.min.js"
    integrity="sha512-/2sZKAsHDmHNoevKR/xsUKe+Bpf692q4tHNQs9VWWz0ujJ9JBM67iFYbIEdfDV9I2BaodgT5MIg/FTUmUv3oyQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"
    integrity="sha512-CEiA+78TpP9KAIPzqBvxUv8hy41jyI3f2uHi7DGp/Y/Ka973qgSdybNegWFciqh6GrN2UePx2KkflnQUbUhNIA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.counterup@2.1.0/jquery.counterup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/5.0.0/imagesloaded.pkgd.min.js"
    integrity="sha512-kfs3Dt9u9YcOiIt4rNcPUzdyNNO9sVGQPiZsub7ywg6lRW5KuK1m145ImrFHe3LMWXHndoKo2YRXWy8rnOcSKg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"
    integrity="sha512-Zq2BOxyhvnRFXu0+WE6ojpZLOU2jdnqbrM1hmVdGzyeCa1DgM3X5Q4A/Is9xA1IkbUeDd7755dNNI/PzSf2Pew=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scroll/16.1.3/smooth-scroll.min.js"
    integrity="sha512-HYG9E+RmbXS7oy529Nk8byKFw5jqM3R1zzvoV2JnltsIGkK/AhZSzciYCNxDMOXEbYO9w6MJ6SpuYgm5PJPpeQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightcase/2.5.0/js/lightcase.min.js"
    integrity="sha512-i+A2/k3mB4TtIRp6fyk8Q+xzJqKusi0bvFgCIfDtdJT1tDEMqYvKo60q3bvp6LzGIeS6BahqN4AklwwxbdSaog=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/search.js?v=2"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"
    integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"
    integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxchimp/1.3.0/jquery.ajaxchimp.min.js"
    integrity="sha512-5yj5elY9u6clGe9/97bj3jJlw8+O9XSv/tbme8m/LR8cKnnT5+rR8qHW/UYQ/MozLg3cvTHeYIpM5kRktASSbg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/newsletter.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.js"
    integrity="sha512-RTxmGPtGtFBja+6BCvELEfuUdzlPcgf5TZ7qOVRmDfI9fDdX2f1IwBq+ChiELfWt72WY34n0Ti1oo2Q3cWn+kw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"
    integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/searched.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/forms-2.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/range.js?v=2"></script>
<script type="text/javascript" src="{{ URL::to('/') }}/js/color-switcher.js?v=2"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    var errorMessage = "{{ session('error') }}";

    if (errorMessage) {
        Swal.fire({
            position: "center",
            icon: "warning",
            text: errorMessage,
            showClass: {
                popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `
            },
            hideClass: {
                popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `
            },
            showConfirmButton: false,
            timer: 2000
        });

    }

    var successMessage = "{{ session('success') }}";

    if (successMessage) {
        Swal.fire({
            position: "center",
            icon: "success",
            text: successMessage,
            showClass: {
                popup: `
      animate__animated
      animate__fadeInUp
      animate__faster
    `
            },
            hideClass: {
                popup: `
      animate__animated
      animate__fadeOutDown
      animate__faster
    `
            },
            showConfirmButton: false,
            timer: 2000
        });
    }
</script>

<script>
    // Sayfa kaydırıldığında butonu göster/gizle
    window.onscroll = function() {
        var scrollToTopBtn = document.getElementById("scrollToTopBtn");
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };

    // Sayfanın en üstüne kaydır
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Yumuşak kaydırma için
        });
    }
</script>


<script>
    $(document).ready(function() {
        $('.listingDetailsSliderNav .item').on('mouseenter', function() {
            var totalSlides = $('#listingDetailsSlider .carousel-item')
                .length; // Toplam slayt sayısını al
            // 'this' bağlamında jQuery öğesi olduğunu varsayarak
            var dataSlideTo = $(this).find('a').attr('data-slide-to');
            // dataSlideTo değerini integer'a dönüştür ve 1 ekle
            var slideNumber = parseInt(dataSlideTo, 10) + 1;
            $('.pagination .page-item-middle .page-link').text((slideNumber) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
            $('#listingDetailsSlider .carousel-inner .item').removeClass('active');
            $('#listingDetailsSlider .carousel-inner .item[data-slide-number="' + dataSlideTo + '"]')
                .addClass('active');
            $('.listingDetailsSliderNav .item').removeClass('active');
            $(this).closest('.item').addClass('active');
            $(this).css('border', '1px solid #EC2F2E'); // Border rengini kırmızı yap
            var totalSlides = $('#listingDetailsSlider .carousel-item')
                .length; // Toplam slayt sayısını al
            $('.pagination .page-item-middle .page-link').text((slideNumber) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
        }).on('mouseleave', function() {
            $(this).css('border', 'solid 1px #e6e6e6'); // Hover bittiğinde border rengini boş bırak
        });

    });

    $(document).ready(function() {
        $('.listingDetailsSliderNav .item a').on('click', function() {
            var dataSlideTo = $(this).attr('data-slide-to');
            console.log(dataSlideTo);
            var slideNumber = parseInt(dataSlideTo, 10);
            $('#listingDetailsSlider .carousel-inner .item').removeClass('active');
            $('#listingDetailsSlider .carousel-inner .item[data-slide-number="' + dataSlideTo + '"]')
                .addClass('active');
            $('.listingDetailsSliderNav .item').removeClass('active');
            $(this).closest('.item').addClass('active');
        });
    });
    var isLoggedIn = {!! json_encode(auth()->check()) !!};
    var hasClub = isLoggedIn == true ? {!! auth()->user() ? json_encode(auth()->user()->has_club) : 4 !!} : 4;

    $('body').on('click', '.addCollection', function(event) {

        event.preventDefault();
        if (!isLoggedIn) {
            toastr.warning('Lütfen Giriş Yapınız', 'Uyarı');
            redirectToLogin();
            return;

        }





        var button = $(this);
        var productId = $(this).data("id");
        var project = null;
        var type = $(this).data("type");

        if ($(this).data("type") == "project") {
            project = $(this).data("project");
        }
        if (isLoggedIn && hasClub == 0 || hasClub == 2 || hasClub == 3) {
            $('#membershipPopup').modal('show');

        } else if (isLoggedIn && hasClub ==
            1) {
            $('#addCollectionModal').modal('show');
            $(".addCollection").data('cart-info', {
                id: productId,
                type: type,
                project: project,
                _token: "{{ csrf_token() }}",
                clear_cart: "no",
                selectedCollectionId: null
            });


            fetch('/getCollections')
                .then(response => response.json())
                .then(data => {
                    var text;
                    var pluralText;

                    if (isLoggedIn) {
                        var accountType = {!! Auth::check() ? json_encode(Auth::user()->corporate_type) : 'null' !!};
                        if (accountType === "Emlak Ofisi") {
                            text = "Portföy";
                            pluralText = "Portföylerden";
                        } else {
                            text = "Koleksiyon";
                            pluralText = "Koleksiyonlardan";
                        }
                    } else {
                        text = "Koleksiyon";
                        pluralText = "Koleksiyonlardan";
                    }

                    let modalContent =
                        `<div class="modal-header">
          <h3 class="modal-title fs-5" id="exampleModalLabel">${text} Ekle</h3>
       </div>
       <div class="modal-body collection-body">`;

                    if (data.collections.length > 0) {
                        modalContent +=
                            `<span class="collectionTitle mb-3">${pluralText} birini seç veya yeni bir ${text} oluştur</span>`;
                        modalContent +=
                            `<div class="collection-item-wrapper" id="selectedCollectionWrapper">
            <ul class="list-group" id="collectionList" style="justify-content: space-between;">`;

                        data.collections.forEach(collection => {
                            modalContent +=
                                `<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important" data-collection-id="${collection.id}">
             ${collection.name}
           </li>`;
                        });

                        modalContent +=
                            `<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important">
           <i class="fa fa-plus" style="color:#e54242;"></i> Yeni Ekle
         </li>`;
                        modalContent += '</ul></div>';
                    } else {
                        modalContent += `<p>Henüz ${text} yok. Yeni bir ${text} oluştur:</p>`;
                        modalContent +=
                            `<div class="collection-item-wrapper" id="selectedCollectionWrapper">
            <ul class='list-group' id='collectionList' style='justify-content: space-between;'>`;
                        modalContent +=
                            `<li class='list-group-item mb-3' style='cursor:pointer;color:black;font-size:11px !important'>
           <i class='fa fa-plus' style='color:#e54242;'></i> Yeni Ekle
         </li>`;
                        modalContent += '</ul></div>';
                    }

                    modalContent +=
                        '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button></div>';

                    let modal = document.getElementById('addCollectionModal');
                    let modalBody = modal.querySelector('.modal-content');
                    modalBody.innerHTML = modalContent;

                    // Olay dinleyicilerini yeniden ekleyin
                    document.querySelectorAll('#collectionList li').forEach(item => {
                        item.addEventListener('click', function() {
                            let selectedCollectionId = this.getAttribute(
                                'data-collection-id');
                            if (!this.isEqualNode(document.querySelector(
                                    '#collectionList li:last-child'))) {
                                var cart = {
                                    id: productId,
                                    type: type,
                                    project: project,
                                    _token: "{{ csrf_token() }}",
                                    clear_cart: "no",
                                    selectedCollectionId: parseInt(selectedCollectionId,
                                        10)
                                };

                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('add.to.link') }}",
                                    data: JSON.stringify(cart),
                                    contentType: "application/json;charset=UTF-8",
                                    success: function(response) {
                                        if (response.failed) {
                                            toastr.warning(
                                                "Ürün bu koleksiyonda zaten mevcut."
                                            );
                                        } else {
                                            toastr.success(
                                                "Ürün Koleksiyonunuza Eklendi"
                                            );
                                        }
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });

                                closeModal();
                            }
                        });
                    });

                    document.querySelector('#collectionList li:last-child').addEventListener('click',
                        function() {
                            $('#addCollectionModal').modal('hide');
                            $('#newCollectionModal').modal('show');
                        });
                });

        }

        function redirectToLogin() {
            window.location.href = '/giris-yap';
        }



    });


    $('#saveNewCollectionBtn').on('click', function() {


        if (isLoggedIn && hasClub == 0 || hasClub == 2 || hasClub == 3) {
            $('#membershipPopup').modal('show');
        } else if (!isLoggedIn) {
            redirectToLogin();
        } else if (isLoggedIn && hasClub == 1) {
            $(".modal-backdrop").hide();

            let newCollectionName = $('#newCollectionNameInput').val();
            let cartInfo = $('.addCollection').data('cart-info');
            if (newCollectionName) {
                $.ajax({
                    type: 'POST',
                    url: '/collections',
                    data: {
                        collection_name: newCollectionName,
                        _token: "{{ csrf_token() }}",
                        cart: cartInfo
                    },
                    success: function(response) {
                        console.log(response);
                        if (response) {
                            $('#newCollectionModal').modal('hide');
                            $('#newCollectionNameInput').val(" ");
                            toastr.success("Ürün Koleksiyonunuza Eklendİ");

                        } else {
                            toastr.error('Koleksiyon eklenirken bir hata oluştu.');
                        }
                    },
                    error: function(error) {
                        console.error('Koleksiyon eklenirken bir hata oluştu:', error);
                    }
                });
            } else {
                toastr.warning('Lütfen yeni bir koleksiyon adı girin.');
            }
        }

    });

    document.addEventListener('DOMContentLoaded', () => {
        const cookieModal = document.getElementById('cookie-management-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const backButton = document.getElementById('back-button');
        const cookieContent = document.getElementById('cookie-management-content');
        const vendorInfoContent = document.getElementById('vendor-info-content');
        const vendorInfoTableBody = document.getElementById('vendor-info-table-body');
        const btnViewVendorInfo = document.querySelectorAll('.btn-view-vendor-info');

        // Modalı aç ve kapat
        btnViewVendorInfo.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.getAttribute('data-category');
                const tabName = button.getAttribute('data-tab-name');
                cookieContent.classList.add('hidden');
                openVendorInfoContent(category, tabName);
            });
        });

        closeModalBtn.addEventListener('click', () => {
            cookieModal.classList.add('hidden');
        });

        backButton.addEventListener('click', () => {
            showCookieManagementContent();
        });


        function openVendorInfoContent(category, tabName) {
            // Kategoriye göre satıcı bilgilerini yükle
            fetchVendorInfo(category)
                .then(vendorInfo => {
                    vendorInfoTableBody.innerHTML = vendorInfo.map(vendor => `
            <tr>
                 <td>Ad: </td>
                <td>${vendor.cookie_name}</td>
                </tr>
                 <tr>
                 <td>Ana Bilgisayar: </td>
                <td>${vendor.site_domain}</td>
                </tr>
                  <tr>
                 <td>Süre: </td>
                <td>${vendor.expiry_duration || 'N/A'}</td>
                </tr>
                  <tr>
                 <td>Tür: </td>
                <td>${vendor.cookie_type || 'N/A'}</td>
                </tr>
                  <tr>
                 <td>Açıklama: </td>
                <td>${vendor.description || 'N/A'}</td>
                </tr>
            </tr>
        `).join('');
                })
                .catch(error => {
                    console.error('Satıcı bilgilerini yüklerken bir hata oluştu:', error);
                    vendorInfoTableBody.innerHTML =
                        '<tr><td colspan="5">Bilgiler yüklenirken bir hata oluştu.</td></tr>';
                });

            cookieContent.classList.add('hidden');
            vendorInfoContent.classList.remove('hidden');
            backButton.classList.remove('hidden');
            document.getElementById('vendor-info-title').innerText = `${tabName} - Satıcı Bilgileri`;
        }

        function showCookieManagementContent() {
            vendorInfoContent.classList.add('hidden');
            cookieContent.classList.remove('hidden');
            backButton.classList.add('hidden');
            document.getElementById('modal-title').innerText = 'Çerez Yönetimi';
        }

        function fetchVendorInfo(category) {
            // API'den veya veritabanından kategoriye göre satıcı bilgilerini çek
            return fetch(`/api/cookie-policy/${category}`)
                .then(response => response.json())
                .then(data => data.preferences || []) // `data.preferences` satıcı bilgilerini içermelidir
                .catch(error => {
                    console.error('Satıcı bilgilerini çekerken bir hata oluştu:', error);
                    return []; // Boş bir dizi döndür
                });
        }

    });


    function closeModal() {
        $(".modal-backdrop").hide();
        $('#addCollectionModal').modal('hide');
        $('#newCollectionModal').modal('hide');
    }

    $(document).ready(function() {
        $(".box").hide();

        $(".notification").click(function(e) {
            e.stopPropagation(); // Bu, dışarı tıklandığında belge olayının tetiklenmesini önler
            $(".box").toggle();
        });

        $(document).click(function(e) {
            if (!$(e.target).closest('.box').length && !$(e.target).closest('.notification').length) {
                $(".box").hide();
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        var notificationCards = document.querySelectorAll(".notification-card");
        notificationCards.forEach(function(card) {
            card.addEventListener("click", function() {
                var notificationId = card.getAttribute("data-id");
                var notificationLink = $(this).data('link');

                fetch('/mark-notification-as-read/' + notificationId, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(function(response) {

                        if (response.status == "readed") {
                            var numberCount = parseInt($(".notBtn .number").html());
                            if (numberCount > 0) {
                                numberCount--;
                                $(".notBtn .number").html(numberCount);
                            }
                        }

                        if (notificationLink) {
                            window.location.href = notificationLink;
                        }
                        card.classList.remove("unread");
                        card.classList.add("read");

                    })
                    .catch(function(error) {
                        console.error('Bir hata oluştu:', error);
                    });
            });
        });
    });
    $('body').on('click', '.payment-plan-button', function(event) {
        var order = $(this).attr('order');
        var block = $(this).data("block");
        var message = $(this).data("message");

        var paymentOrder = $(this).data("payment-order");
        var soldStatus = $(this).data('sold');

        var cart = {
            project_id: $(this).attr('project-id'),
            order: $(this).attr('order'),
            _token: "{{ csrf_token() }}"
        };

        var paymentPlanDatax = {
            "pesin": "Peşin",
            "taksitli": "Taksitli"
        }

        function getDataJS(project, key, roomOrder) {
            var a = 0;
            project.room_info.forEach((room) => {
                if (room.room_order == roomOrder && room.name == key) {
                    a = room.value;
                }
            })

            return a;

        }

        var userCheck = {!! auth()->user() ? json_encode(auth()->user()->id) : 0 !!};


        if (userCheck == 0) {
            if (message) {
                if (message == "approve") {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Projeye teklif göndermek için lütfen giriş yapınız.',
                        showCancelButton: true,
                        confirmButtonText: 'Giriş Yap',
                        cancelButtonText: 'Kapat',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buraya kullanıcıyı giriş sayfasına yönlendiren kodu ekleyin
                            window.location.href =
                                '/giris-yap'; // Giriş sayfanızın URL'sini buraya koyun
                        }
                    });

                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Uyarı',
                        text: 'Projeye başvurmak için lütfen giriş yapınız.',
                        showCancelButton: true,
                        confirmButtonText: 'Giriş Yap',
                        cancelButtonText: 'Kapat',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Buraya kullanıcıyı giriş sayfasına yönlendiren kodu ekleyin
                            window.location.href =
                                '/giris-yap'; // Giriş sayfanızın URL'sini buraya koyun
                        }
                    });
                }

            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Uyarı',
                    text: 'Ödeme detayını görüntülemek için lütfen giriş yapınız.',
                    showCancelButton: true,
                    confirmButtonText: 'Giriş Yap',
                    cancelButtonText: 'Kapat',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Buraya kullanıcıyı giriş sayfasına yönlendiren kodu ekleyin
                        window.location.href = '/giris-yap'; // Giriş sayfanızın URL'sini buraya koyun
                    }
                });
            }

        } else if (soldStatus == "1") {
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı',
                text: 'Bu ilan için ödeme detay bilgisi gösterilemiyor.',
                confirmButtonText: 'Kapat'
            });
        } else {
            $.ajax({
                url: "{{ route('get.housing.payment.plan') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "get", // Veriyi göndermek için POST kullanabilirsiniz
                data: cart,
                success: function(response) {
                    for (var i = 0; i < response.room_info.length; i++) {
                        var numberOfShares = 0;
                        var shareSale = getDataJS(response, "share_sale[]", response.room_info[i]
                            .room_order);
                        if (shareSale && shareSale == '["Var"]') {
                            var numberOfShares = parseFloat(getDataJS(response,
                                "number_of_shares[]",
                                response.room_info[i].room_order));


                        }


                        if (response.room_info[i].name == "payment-plan[]" && response.room_info[i]
                            .room_order == parseInt(order)) {


                            var paymentPlanData = JSON.parse(response.room_info[i].value);
                            if (!paymentPlanData.includes("pesin")) {
                                // "peşin" not present, add it to the beginning of the array
                                paymentPlanData.unshift("pesin");
                            } else if (!paymentPlanData.includes("taksitli")) {
                                // "peşin" already present, but "taksitli" is not, add "taksitli" to the end
                                const indexOfPesin = paymentPlanData.indexOf("pesin");
                                paymentPlanData.splice(indexOfPesin + 1, 0, "taksitli");
                            }

                            if (paymentPlanData[0] != "pesin") {
                                paymentPlanData.reverse();

                            }


                            var html = "";

                            function formatPrice(number) {
                                number = parseFloat(number);
                                // Sayıyı ondalık kısmı virgülle ayır
                                const parts = number.toFixed(2).toString().split(".");

                                // Virgül ile ayırmak için her üç haneli kısma nokta ekleyin
                                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                                // Sonucu birleştirin ve virgül ile ayırın
                                return parts.join(",");
                            }
                            var tempPlans = [];
                            const months = ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
                                "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
                            ]
                            orderHousing = parseInt(order);
                            var userTypeOne = {!! auth()->user() ? json_encode(auth()->user()->type) : 0 !!};

                            if (getDataJS(response, "discount_rate[]",
                                    response.room_info[i].room_order) && userTypeOne == 1) {
                                html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                    "' style='background-color: green !important;color:white;font-weight: 100'>" +
                                    "<th style='text-align:center' class='paymentTableTitle' colspan='" +
                                    (4 + parseInt(getDataJS(response, "pay-dec-count" +
                                        orderHousing, response.room_info[i].room_order), 10)) +
                                    "'>" +
                                    "EN YAKIN EMLAK OFİSİNİN KOLEKSİYONU İLE BU İLANI SATIN ALIRSANIZ, %" +
                                    (getDataJS(response, "discount_rate[]", response.room_info[i]
                                        .room_order)) +
                                    " ORANINDA İNDİRİM KAZANIRSINIZ." +
                                    "</th></tr>";


                            }

                            html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                "' style='background-color: #EEE !important;' ><th style='text-align:center' class='paymentTableTitle' colspan=" +
                                (4 + parseInt(getDataJS(response, "pay-dec-count" + orderHousing,
                                    response.room_info[i].room_order), 10)) + " >" + response
                                .project_title +
                                " Projesinde " + block + " " + paymentOrder +
                                " No'lu İlan Ödeme Planı</th></tr>";

                            $(".pop-up-top-gradient .left h3").html(
                                response
                                .project_title +
                                " Projesinde " + block + " " + paymentOrder +
                                " No'lu İlan Ödeme Planı"
                            )
                            var userCheck = {!! json_encode(auth()->user()) !!};

                            if (userCheck) {
                                var discount = getDataJS(response, "number_of_shares[]", response
                                    .room_info[i].room_order);

                                if (userCheck.corporate_type === "Emlak Ofisi" && userCheck.type ===
                                    "2") {
                                    $(".textAlert").html(
                                        "Emlak Sepette, bu ilanı koleksiyonunuza ekleyerek %" +
                                        discount +
                                        " oranındaki indirimle müşterilerinize sunmanıza aracılık eder. Bu fırsatı değerlendirin ve ilanın avantajlarını müşterilerinize daha etkili bir şekilde iletin."
                                    );
                                } else if (userCheck.type === "1") {
                                    $(".textAlert").html(
                                        "Emlak Sepette, bu ilanı en yakın emlak ofisinizin koleksiyonundan %" +
                                        discount +
                                        " oranındaki indirimle satın almanıza aracılık eder. Bu fırsatı kaçırmayın! Detaylar ve daha fazla bilgi için hemen ofisinizle iletişime geçin."
                                    );
                                }
                            }







                            for (var j = 0; j < paymentPlanData.length; j++) {

                                if (!tempPlans.includes(paymentPlanData[j])) {
                                    if (paymentPlanData[j] == "pesin") {
                                        var priceData = numberOfShares != 0 ? (getDataJS(response,
                                                "price[]", response
                                                .room_info[i].room_order) / numberOfShares) :
                                            getDataJS(response, "price[]", response
                                                .room_info[i].room_order);
                                        var installementData = "";
                                        var advanceData = "";
                                        var monhlyPrice = "";




                                        var projectedEarnings = getDataJS(response,
                                            "projected_earnings[]", response.room_info[i]
                                            .room_order);

                                        var ongKira = getDataJS(response,
                                            "ong_kira[]", response.room_info[i]
                                            .room_order);
                                        // var projectedEarnings = 10;



                                    } else {


                                        var priceData = numberOfShares != 0 ? (getDataJS(response,
                                                "installments-price[]", response
                                                .room_info[i].room_order) / numberOfShares) :
                                            getDataJS(response, "installments-price[]", response
                                                .room_info[i].room_order);

                                        var installementData = getDataJS(response, "installments[]",
                                            response.room_info[i].room_order);

                                        var advanceData = numberOfShares != 0 ? formatPrice(
                                            getDataJS(response,
                                                "advance[]",
                                                response.room_info[i].room_order) /
                                            numberOfShares) + "₺" : formatPrice(getDataJS(
                                            response,
                                            "advance[]",
                                            response.room_info[i].room_order)) + "₺";

                                        var monhlyPrice = numberOfShares != 0 ? formatPrice(((
                                                    parseFloat(
                                                        getDataJS(
                                                            response,
                                                            "installments-price[]", response
                                                            .room_info[i].room_order)) -
                                                    parseFloat(getDataJS(response,
                                                        "advance[]", response.room_info[
                                                            i].room_order)) - (payDecPrice *
                                                        numberOfShares)) /
                                                parseInt(installementData)) / numberOfShares) +
                                            "₺" : formatPrice((parseFloat(getDataJS(
                                                        response,
                                                        "installments-price[]", response
                                                        .room_info[i].room_order)) -
                                                    parseFloat(getDataJS(response,
                                                        "advance[]", response.room_info[
                                                            i].room_order)) - (payDecPrice)) /
                                                parseInt(installementData)) + "₺";
                                    }
                                    var isMobile = window.innerWidth < 768;

                                    orderHousing = parseInt(order);



                                    if (paymentPlanData[j] == "pesin") {
                                        var payDecPrice = 0;

                                        var projectedEarningsData = "";
                                        var ongKiraData = "";
                                        var svgCode =
                                            '<svg viewBox="0 0 24 24" width="21" height="21" stroke="green" stroke-width="2" fill="green" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 7 23 12"></polyline></svg>';
                                        var projectedEarningsHTML = projectedEarnings ?
                                            svgCode +
                                            "<strong style='color:#28a745'> Öngörülen Yıllık Kazanç:</strong>" +
                                            "<span style='color:#28a745'> %" +
                                            projectedEarnings +
                                            "</span>" : "";

                                        var ongKiraHTML = ongKira ? svgCode +
                                            "<strong style='color:#28a745'> Öngörülen Kira Getirisi:</strong>" +
                                            "<span style='color:#28a745'>" + ongKira +
                                            " TL</span>" : "";

                                        projectedEarningsData += projectedEarningsHTML;
                                        ongKiraData += ongKiraHTML;

                                        html += "<tr><td>Öngörülen Kazanç Durumu</td>";

                                        if (projectedEarningsData) {
                                            html += "<td>" + projectedEarningsData + "</td>";

                                        }


                                        if (ongKiraData) {
                                            html += "<td>" + ongKiraData + "</td></tr>";

                                        }
                                    }


                                    if (paymentPlanDatax[paymentPlanData[j]] == "Taksitli") {
                                        html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                            "' style='background-color: #EEE !important;'><th>" +
                                            installementData +
                                            " Ay Taksitli Fiyat</th><th>Peşinat</th><th>Aylık Ödenecek Miktar</th></tr>";




                                    }

                                    html += "<tr>";

                                    // Function to check if the value is empty or not
                                    function isNotEmpty(value) {
                                        return value !== "" && value !== undefined && value !==
                                            "-" &&
                                            value !== null;
                                    }

                                    if (!isMobile && isNotEmpty(paymentPlanDatax[paymentPlanData[
                                            j]]) && paymentPlanDatax[paymentPlanData[j]] !=
                                        "Taksitli") {
                                        html += "<td>" + (isMobile ?
                                            "<strong>Ödeme Türü:</strong> " :
                                            "") + paymentPlanDatax[paymentPlanData[j]] + "</td>";
                                    }

                                    if (!isMobile || isNotEmpty(formatPrice(priceData))) {

                                        if (paymentPlanDatax[paymentPlanData[j]] === 'Taksitli') {
                                            html += "<td><strong>" + (
                                                isMobile ? paymentPlanDatax[
                                                    paymentPlanData[j]] + " " +
                                                installementData + " Ay " +
                                                "Fiyat:</strong> " : "") + formatPrice(
                                                priceData) + "₺</td>";
                                        } else {
                                            html += "<td><strong>" + (isMobile ? paymentPlanDatax[
                                                    paymentPlanData[j]] + " " +
                                                "Fiyat:</strong> " : "") + formatPrice(
                                                priceData) + "₺</td>";



                                        }


                                    }


                                    if (!isMobile || isNotEmpty(advanceData)) {
                                        html += advanceData ? "<td>" + (isMobile ?
                                            "<strong>Peşinat:</strong> " :
                                            "") + advanceData + "</td>" : null;
                                    }

                                    if (!isMobile || isNotEmpty(monhlyPrice)) {
                                        html += monhlyPrice ? "<td>" + (isMobile ?
                                            "<strong>Aylık Ödenecek Tutar:</strong> " :
                                            "") + monhlyPrice + "</td>" : null;
                                    }

                                    if (!isMobile && isNotEmpty(installmentsPrice) &&
                                        paymentPlanDatax[
                                            paymentPlanData[j]] != "Taksitli") {
                                        var installmentsPrice = parseFloat(getDataJS(response,
                                            "installments-price[]", response.room_info[i]
                                            .room_order));
                                        var advanceAmount = parseFloat(getDataJS(response,
                                            "advance[]", response.room_info[i].room_order));

                                        // Check if the values are valid numbers
                                        if (!isNaN(installmentsPrice) && !isNaN(advanceAmount) && !
                                            isNaN(payDecPrice)) {
                                            var calculatedValue = installmentsPrice -
                                                advanceAmount - payDecPrice;

                                            html += "<td>" + (isMobile ?
                                                    "<strong>Ara Ödemeler Çıkınca Ödenecek Tutar:</strong> " :
                                                    "") +
                                                formatPrice(calculatedValue) + "</td>";
                                        }
                                    }



                                    if (!isMobile && isNotEmpty(installementData) &&
                                        paymentPlanDatax[paymentPlanData[j]] != "Taksitli") {
                                        html += "<td>" + (isMobile ?
                                                "<strong>Taksit Sayısı:</strong> " : "") +
                                            installementData + "</td>";
                                    }


                                    var payDecPrice = 0;
                                    if (getDataJS(response, "pay-dec-count" + (orderHousing),
                                            response.room_info[i].room_order)) {

                                        for (var l = 0; l < getDataJS(response, "pay-dec-count" + (
                                                    orderHousing), response.room_info[i]
                                                .room_order); l++) {



                                            if (getDataJS(response, "pay_desc_price" + (
                                                        orderHousing) + l, response.room_info[i]
                                                    .room_order)) {
                                                var price = parseFloat(getDataJS(response,
                                                    "pay_desc_price" + (orderHousing) + l,
                                                    response.room_info[i].room_order));
                                                var payDecPrice = numberOfShares ? price /
                                                    numberOfShares : price;
                                                var payDescDate = new Date(getDataJS(response,
                                                    "pay_desc_date" + (orderHousing) + l,
                                                    response.room_info[i].room_order));


                                                if (paymentPlanDatax[paymentPlanData[j]] ==
                                                    "Taksitli") {
                                                    if (l == 0) {
                                                        html +=
                                                            "<tr><th style='background-color: #EEE !important;' colspan='3'>Ara Ödemeler</th></tr>";
                                                    }
                                                    html += "<tr>";

                                                    // Ara Ödeme
                                                    html += "<td>" + "<strong>" + (l + 1) +
                                                        ". Ara Ödeme :</strong> <br>" + "</td>";

                                                    // Price
                                                    html += "<td>" + formatPrice(payDecPrice) +
                                                        "₺" + "</td>";

                                                    // Tarih
                                                    html += "<td>" + (months[payDescDate
                                                                .getMonth()] + ' ' + payDescDate
                                                            .getDate() +
                                                            ', ' + payDescDate.getFullYear()) +
                                                        "</td>";


                                                    html += "</tr>";
                                                }
                                            }



                                        }
                                    }




                                    html += "</tr>";
                                }

                                tempPlans.push(paymentPlanData[j])

                            }


                            $('.payment-plan tbody').html(html);

                            $('.payment-plan-pop-up').removeClass('d-none')

                            document.getElementById("whatsappButton").addEventListener("click",
                                function() {
                                    var projectSlug = response.slug + "-" + response
                                        .step2_slug + "-" + response.housing_type.slug;
                                    var projectID = response.id + 1000000;
                                    var housingOrder = paymentOrder;

                                    var domain = window.location.origin;
                                    var url = domain + '/proje/' + projectSlug + '/ilan/' +
                                        projectID + '/' + housingOrder + '/detay' +
                                        "/odeme-plani";


                                    // Whatsapp yönlendirme URL'sini oluştur
                                    var whatsappURL = 'https://api.whatsapp.com/send?text=' +
                                        encodeURIComponent(url);



                                    window.open(whatsappURL, '_blank');
                                });
                        }
                    }
                },
                error: function(error) {
                    // Hata durumunda buraya gelir
                    toast.error(error)
                    console.error("Hata oluştu: " + error);
                }
            });
        }

    })





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
    $('.payment-plan-pop-back').click(function() {
        $('.payment-plan-pop-up').addClass('d-none')
    })

    $('.payment-plan-pop-close-icon').click(function() {
        $('.payment-plan-pop-up').addClass('d-none')
    })
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

    $('.slick-lancers').slick({
        infinite: false,
        slidesToShow: 10,
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
                slidesToShow: 4,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }]
    });

    $('.slick-lancershb').slick({
        infinite: false,
        slidesToShow: 5,
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
                slidesToShow: 4,
                slidesToScroll: 4,
                dots: false,
                arrows: false
            }
        }]
    });

    $('.home5-right-slider').owlCarousel({
        loop: true,
        margin: 30,
        dots: false,
        nav: true,
        rtl: false,
        autoplayHoverPause: false,
        autoplay: true,
        singleItem: true,
        smartSpeed: 1200,
        navText: ["<i class='fas fa-angle-left'></i>", "<i class='fas fa-angle-right'></i>"],
        responsive: {
            0: {
                items: 1,
                center: false,
                nav: false,
            },
            480: {
                items: 1,
                center: false,
                nav: false,

            },
            520: {
                items: 1,
                center: false,
                nav: false,

            },
            600: {
                items: 1,
                center: false,
                nav: false,

            },
            768: {
                items: 1,
                nav: false,

            },
            992: {
                items: 1,
                nav: false,

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
    $(".dropdown-filter").on('click', function() {

        $(".explore__form-checkbox-list").toggleClass("filter-block");

    });
</script>

<!-- Slider Revolution scripts -->
<script src="{{ URL::to('/') }}/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="{{ URL::to('/') }}/revolution/js/jquery.themepunch.revolution.min.js"></script>
<!-- lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<!-- jQuery -->

<!-- lightbox2 JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<!-- MAIN JS -->
<script src="{{ URL::to('/') }}/js/script.js"></script>

<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!-- SweetAlert2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        // checkFavorites();
        // checkProjectFavorites();
        var cart = @json(session('cart', []));

        var addToCartButtons = document.querySelectorAll(".CartBtn");
        $('body').on('click', '.CartBtn', function(event) {
            event.preventDefault();

            var button = event.target;
            var productId = $(this).data("id");
            var isShare = $(this).data("share");
            var numbershare = $(this).data("number-share");
            var project = null;

            if ($(this).data("type") == "project") {
                project = $(this).data("project");
            }

            var cart = {
                id: productId,
                isShare: isShare,
                numbershare: parseInt(numbershare, 10),
                qt: 1,
                type: $(this).data("type"),
                project: project,
                _token: "{{ csrf_token() }}",
                clear_cart: "no"
            };

            if (isProductInCart(productId, project)) {
                Swal.fire({
                    title: "Ürünü sepetten kaldırmak istiyor musunuz?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: "Evet, Kaldır",
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('add.to.cart') }}",
                            data: JSON.stringify(cart),
                            contentType: "application/json;charset=UTF-8",
                            success: function(response) {
                                if (response.message == "success") {
                                    toastr.error("Ürün Sepetten Kaldırılıyor.");
                                    button.classList.remove("bg-success");
                                    location.reload();
                                } else if (response.message == "session") {
                                    window.location.href = "/giris-yap"
                                }
                            },
                            error: function(error) {
                                // window.location.href = "/giris-yap";
                            }
                        });
                    }
                });
            } else {
                Swal.fire({
                    title: isCartEmpty() ? 'Sepete eklemek istiyor musunuz?' :
                        'Mevcut sepeti temizlemek istiyor musunuz?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: isCartEmpty() ? 'Evet' : 'Evet, temizle',
                    cancelButtonText: 'Hayır',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('add.to.cart') }}",
                            data: JSON.stringify(cart),
                            contentType: "application/json;charset=UTF-8",
                            success: function(response) {
                                if (response.message == "success") {
                                    toastr.success("Ürün Sepete Eklendi");
                                    if (!button.classList.contains("mobile")) {
                                        button.textContent = "Sepete Eklendi";
                                        window.location.href = "/sepetim";
                                    }
                                    button.classList.add("bg-success");

                                } else if (response.message == "session") {
                                    window.location.href = "/giris-yap"
                                }
                            },
                            error: function(error) {
                                if (error.status === 401) {
                                    // window.location.href = "/giris-yap";
                                } else {
                                    console.error(error);
                                }
                            }
                        });
                    }
                });
            }
        });


        $('body').on('click', '.disabledShareButton', function(event) {
            event.preventDefault();
            toastr.error("Satışa kapalı ürünleri koleksiyonunuza ekleyemezsiniz.");
        });

        updateCartButton();

        function updateCartButton() {
            var CartBtn = document.querySelectorAll(".CartBtn");
            CartBtn.forEach(function(button) {
                var productId = button.getAttribute("data-id");
                var productType = button.getAttribute("data-type");
                var product = null;
                if (productType == "project") {
                    product = button.getAttribute("data-project");
                }

                if (isProductInCart(productId, product)) {
                    if (!button.classList.contains("mobile")) {
                        button.querySelector(".text").textContent = "Sepete Eklendi";
                    }

                    button.classList.add("bg-success");
                } else {
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
            return false;
        }



        // function checkProjectFavorites() {
        //     // Favorileri sorgula ve uygun renk ve ikonları ayarla
        //     var favoriteButtons = document.querySelectorAll(".toggle-project-favorite");
        //     var projectHousingPairs = []; // Proje ve housing ID'lerini içeren bir dizi

        //     favoriteButtons.forEach(function(button) {
        //         var housingId = button.getAttribute("data-project-housing-id");
        //         var projectId = button.getAttribute("data-project-id");

        //         projectHousingPairs.push({
        //             projectId: projectId,
        //             housingId: housingId
        //         });
        //     });
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');


        //     $.ajax({
        //         url: "{{ route('get.project.housing.favorite.status') }}",
        //         type: "POST",
        //         data: {
        //             _token: csrfToken,
        //             projectHousingPairs: projectHousingPairs
        //         },
        //         success: function(response) {
        //             favoriteButtons.forEach(function(button) {
        //                 var housingId = button.getAttribute(
        //                     "data-project-housing-id");
        //                 var projectId = button.getAttribute("data-project-id");
        //                 var isFavorite = response[projectId][housingId];

        //                 if (isFavorite) {
        //                     button.querySelector("i").classList.remove(
        //                         "fa-heart-o");
        //                     button.querySelector("i").classList.add(
        //                         "fa-heart");
        //                     button.querySelector("i").classList.add(
        //                         "text-danger");
        //                     button.classList.add("bg-white");
        //                 } else {
        //                     button.querySelector("i").classList.remove(
        //                         "text-danger");
        //                     button.querySelector("i").classList.remove(
        //                         "fa-heart");
        //                     button.querySelector("i").classList.add(
        //                         "fa-heart-o");
        //                 }
        //             });
        //         },
        //     });



        // }





        function toggleProjectFavorite(event) {
            event.preventDefault();

            var button = event.target;
            if ($(event.target).is('i')) {
                button = button.closest('.toggle-project-favorite');
            }
            var housingId = button.getAttribute("data-project-housing-id");
            var projectId = button.getAttribute("data-project-id");

            $.ajax({
                url: "{{ route('add.project.housing.to.favorites', ['id' => ':id']) }}".replace(':id',
                    housingId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    project_id: projectId,
                    housing_id: housingId
                },
                success: function(response) {
                    if (response.status == 'added') {
                        updateFavoriteButton(button, true);
                    } else if (response.status == 'removed') {
                        updateFavoriteButton(button, false);
                    } else if (response.status == 'notLogin') {
                        window.location.href =
                            "{{ route('client.login') }}"; // Redirect to the login route
                    }
                },
                error: function(error) {
                    // window.location.href = "/giris-yap";
                }
            });
        }



        // Function to handle the click event for generic favorite toggle
        function toggleFavorite(event) {
            event.preventDefault();
            var housingId = event.currentTarget.getAttribute("data-housing-id");
            var button = event.currentTarget;

            $.ajax({
                url: "{{ route('add.housing.to.favorites', ['id' => ':id']) }}".replace(':id',
                    housingId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status == 'added') {
                        toastr.success("Konut Favorilere Eklendi");
                        updateFavoriteButton(button, true);
                    } else if (response.status == 'removed') {
                        toastr.warning("Konut Favorilerden Kaldırıldı");
                        updateFavoriteButton(button, false);
                    } else if (response.status == 'notLogin') {
                        window.location.href =
                            "{{ route('client.login') }}"; // Redirect to the login route
                    }
                },
                error: function(error) {
                    window.location.href = "/giris-yap";
                    console.error(error);
                }
            });
        }

        // Function to update the favorite button styles
        function updateFavoriteButton(button, isAdded) {
            var heartIconClassList = button.querySelector("i").classList;
            heartIconClassList.remove("text-danger", "fa-heart", "fa-heart-o");

            if (isAdded) {
                heartIconClassList.add("fa-heart", "text-danger");
                button.classList.add("bg-white");
            } else {
                heartIconClassList.add("fa-heart-o");
                button.classList.remove("bg-white");
            }
        }

        // Event delegation for project favorite toggle
        $('body').on('click', '.toggle-project-favorite', toggleProjectFavorite);


        // Event delegation for generic favorite toggle
        $('body').on("click", ".toggle-favorite", toggleFavorite);

    });
    const appUrl = "https://private.emlaksepette.com/"; // Uygulama URL'si
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

                    if (data.housingOrder && data.projectIdNumber && data.project) {
                        hideSearchingMessage();
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">Proje İlanı</div>
                        `);
                        var baseRoute =
                            `{{ route('project.housings.detail', ['projectSlug' => 'slug_placeholder', 'projectID' => 'id_placeholder', 'housingOrder' => 'id_housing_order_placeholder']) }}`
                            .replace('slug_placeholder', data.project.slug)
                            .replace('id_placeholder', parseInt(data.projectIdNumber) + 1000000)
                            .replace('id_housing_order_placeholder', parseInt(data.housingOrder));

                        const formattedName = data.project.project_title.charAt(0).toUpperCase() +
                            data
                            .project.project_title
                            .slice(1);
                        hasResults = true;

                        $('.header-search-box').append(`
                            <a href="${baseRoute}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                <span>${formattedName} ${data.housingOrder} No'lu İlan</span>
                            </a>
                        `);
                    }
                    if (data.housings.length > 0) {
                        hideSearchingMessage();
                        hasResults = true;
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">İkinci-El Emlak</div>
                        `);

                        const maxResultsToShow = 4; // Gösterilecek maksimum sonuç sayısı
                        const housingsToShow = data.housings.slice(0,
                            maxResultsToShow); // İlk 4 sonucu al

                        housingsToShow.forEach((e) => {
                            const imageUrl = `${appUrl}housing_images/${e.photo}`;
                            const formattedName = e.name.charAt(0).toUpperCase() + e.name
                                .slice(1);
                            var baseRoute =
                                `{{ route('housing.show', ['housingSlug' => 'slug_placeholder', 'housingID' => 'id_placeholder']) }}`
                                .replace('slug_placeholder', e.slug)
                                .replace('id_placeholder', parseInt(e.id) + 2000000);

                            //housign.show link eklenecek
                            $('.header-search-box').append(`
                            <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark  align-items-center px-3 py-1" style="gap: 8px;">
                                <span>${formattedName}</span>
                            </a>
                        `);
                        });

                        if (data.housings.length > maxResultsToShow) {
                            const remainingResults = data.housings.length - maxResultsToShow;
                            // Arama terimi "housing" olarak belirleniyor
                            const searchUrl = "{{ route('search.results') }}?searchTerm=" +
                                searchTerm + "&type=housing";

                            // Laravel route'u kullanarak URL oluşturma
                            $('.header-search-box').append(`
                            <a href="${searchUrl}" class="text-muted m-3">${remainingResults} sonuç daha bulunmaktadır.</a>
                        `);
                        }
                    }


                    // Project search
                    if (data.projects.length > 0) {
                        hideSearchingMessage();
                        const maxResultsToShow = 4; // Gösterilecek maksimum sonuç sayısı
                        const projectsToShow = data.projects.slice(0,
                            maxResultsToShow); // İlk 4 sonucu al

                        hasResults = true;
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">Projeler</div>
                        `);

                        projectsToShow.forEach((e) => {
                            const imageUrl =
                                `${appUrl}${e.photo.replace('public', 'storage')}`; // Resim URL'sini uygulama URL'si ile birleştirin
                            const formattedName = e.name.charAt(0).toUpperCase() + e.name
                                .slice(1);
                            var baseRoute =
                                `{{ route('project.detail', ['slug' => 'slug_placeholder', 'id' => 'id_placeholder']) }}`
                                .replace('slug_placeholder', e.slug)
                                .replace('id_placeholder', parseInt(e.id) + 1000000);

                            // Now, you can use it in your append statement:
                            $('.header-search-box').append(`
                                <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                    <span>${formattedName}</span>
                                </a>
                            `);
                        });

                        if (data.projects.length > maxResultsToShow) {
                            const remainingResults = data.projects.length - maxResultsToShow;
                            // Arama terimi "project" olarak belirleniyor
                            const searchUrl = "{{ route('search.results') }}?searchTerm=" +
                                searchTerm + "&type=project";

                            // Laravel route'u kullanarak URL oluşturma
                            $('.header-search-box').append(`
                                <a href="${searchUrl}" class="text-muted m-3">${remainingResults} sonuç daha bulunmaktadır.</a>
                            `);
                        }
                    }

                    if (data.merchants.length > 0) {

                        hideSearchingMessage();
                        hasResults = true;
                        $('.header-search-box').append(`
                            <div class="d-flex font-weight-bold justify-content-center border-bottom border-2 pb-2 pt-3 small">Mağazalar</div>
                        `);
                        const maxResultsToShow = 4; // Gösterilecek maksimum sonuç sayısı
                        const merchantsToShow = data.merchants.slice(0,
                            maxResultsToShow); // İlk 4 sonucu al

                        merchantsToShow.forEach((e) => {
                            const imageUrl =
                                `${appUrl}storage/profile_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin
                            const formattedName = e.name.charAt(0).toUpperCase() + e.name
                                .slice(1);

                            $('.header-search-box').append(`
                        <a href="{{ URL::to('/magaza/') }}/${e.slug}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                            <span>${formattedName}</span>
                        </a>
                    `);
                        });

                        if (data.merchants.length > maxResultsToShow) {
                            const remainingResults = data.merchants.length - maxResultsToShow;
                            // Arama terimi "merchant" olarak belirleniyor
                            const searchUrl = "{{ route('search.results') }}?searchTerm=" +
                                searchTerm + "&type=merchant";

                            // Laravel route'u kullanarak URL oluşturma
                            $('.header-search-box').append(`
                                <a href="${searchUrl}" class="text-muted m-3">${remainingResults} sonuç daha bulunmaktadır.</a>
                            `);
                        }
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

    $('.ss-box').on('input', function() {
        let term = $(this).val();

        if (term != '') {
            $('.header-search-box').addClass('d-flex').removeClass('d-none');
            drawHeaderSearchbox(term);
        } else {
            $('.header-search-box').removeClass('d-flex').addClass('d-none');
        }
    });
    $(document).click(function(event) {

        if (
            $('.toggle > input').is(':checked') &&
            !$(event.target).parents('.toggle').is('.toggle')
        ) {
            $('.toggle > input').prop('checked', false);
        }
    })
    'use strict';
    $(function() {
        const appUrl = "https://private.emlaksepette.com/"; // Uygulama URL'si
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
                        console.log(data.projectHousings);

                        // Housing search
                        if (data.housings.length > 0) {
                            hasResults = true;
                            $('.header-search-box-mobile').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">KONUTLAR</div>
                            `);

                            data.housings.forEach((e) => {
                                const imageUrl =
                                    `${appUrl}housing_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);


                                var baseRoute =
                                    `{{ route('housing.show', ['housingSlug' => 'slug_placeholder', 'housingID' => 'id_placeholder']) }}`
                                    .replace('slug_placeholder', e.slug).replace(
                                        'id_placeholder', parseInt(e.id) + 2000000);

                                //housign.show metodu eklenecek    
                                $('.header-search-box-mobile').append(`
                                  <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                    <span>${formattedName}</span>
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
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);

                                // Assuming you have a JavaScript variable like this:
                                var baseRoute =
                                    `{{ route('project.detail', ['slug' => 'slug_placeholder', 'id' => 'id_placeholder']) }}`
                                    .replace('slug_placeholder', e.slug).replace(
                                        'id_placeholder', parseInt(e.id) + 1000000);


                                // Now, you can use it in your append statement:
                                $('.header-search-box-mobile').append(`
                                <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                    <span>${formattedName}</span>
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
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);

                                $('.header-search-box').append(`
    <a href="{{ URL::to('/magaza/') }}/${e.slug}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
        <span>${formattedName}</span>
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




</body>



</html>
