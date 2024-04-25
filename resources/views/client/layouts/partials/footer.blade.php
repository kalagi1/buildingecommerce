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
                        <div id="5060118346753730"><a
                                href="https://etbis.eticaret.gov.tr/sitedogrulama/5060118346753730" target="_blank">
                                <img style='width:100px; height:120px'
                                    src="data:image/jpeg;base64, iVBORw0KGgoAAAANSUhEUgAAAIIAAACWCAYAAAASRFBwAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAEWISURBVHhe7Z0HuGbT9cYZgjFFC6ITogUJhsGoQYgQokT0HoSIMtE7QUJCohNEF2X0NhF92p1bZ+70YXrvvZr9X79zz/vd9Z27v3LvzJD8k/U8L3N3O+fb5z17r7X22vusYBKWBf72t7+FrDz11FO5/K5du6apjXLzzTfntQH23XffNDeEc845p0m+x3vvvZeU++KLL8JKK62UpF111VVJWiE599xzm7Rz/PHHp7lxueOOO3Jla2trk7Ru3brltZHFcccdl5TzMnz48PCtb30ryf/d736XphaXOXPmhA033DCpc+yxx6apIfzsZz/Lu95S4BVDIrHMZqMUEXr27JmmNkqMCB06dEhzQzjjjDOa5Hu8+eabSbnBgwfn0n77298maYXk5JNPzmsDHHbYYWluXP7617/myooIn3zySV4bWRx66KFJOS/Tpk3L5V9wwQVpamnZeOONkzpfCxG23HLLcMoppzQLBx98cK7BUkS4/PLLk79fffXVNDefCEcccUTS5kUXXZSUA1deeWWS9stf/jKsuuqqSbktttgid/0+ffok7UyYMCGcdtppSdqLL76YpBWSxx9/PFdfuO+++9LcRpk1a1Z4+umnk/v4xS9+kbtPEQHyqf4222yT5K288srJwyLt3nvvTcohH374YdLOI488Ek499dQk//nnn09zQ0Jo/eYs6Ne11loraT9GhDZt2oSTTjopdy/l4MQTTwyrr766flM+EX71q1+llyhfKisr1VhJIgjrrrtumptPhFGjRiVpvXv3zqXx0CTrrbdeknbmmWemKctXhg4dmrsPDxHBy2WXXZbktW3bNsyfPz9NbZT99tsvyeeBxgRy+2sUQowIm2++eZrSPNlkk03Ubj4ReKOaKzBd9cslAm+PxBNBb7cfcqmPLFmyJCEQabD/65CJEycmb7juRaiqqkpLNArDPHm8nePGjUtTG+Xwww9P8jfbbLOwcOHCNLVRdtlll7xrFEKMCJtuumlYsGBBmlqezJs3L2y00UZqtzARrrjiinDIIYcUxMiRI5NyLSECQ9KPf/zjpJ3rr78+UfgAQzHiifD9738/KXfggQeG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" /></a>
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
                <span>2023 © Copyright - Tüm hakları saklıdır. @kodturk</span>

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


    <a href="{{ Auth::check() ? (Auth::user()->type == 1 ? route('institutional.index') : (Auth::user()->type == 2 ? url('institutional/create_project_v2') : (Auth::user()->type == 3 ? route('real.estate.index') : route('real.estate.index')))) : route('client.login') }}"
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
        <div class="payment-plan-pop-close-icon"><i class="fa fa-times"></i></div>

        <div class="my-properties">
            <table class="payment-plan table">
                <a id="whatsappButton" ><svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="30" height="30" viewBox="0 0 48 48">
                    <path fill="#fff" d="M4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5c5.1,0,9.8,2,13.4,5.6	C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19c0,0,0,0,0,0h0c-3.2,0-6.3-0.8-9.1-2.3L4.9,43.3z"></path><path fill="#fff" d="M4.9,43.8c-0.1,0-0.3-0.1-0.4-0.1c-0.1-0.1-0.2-0.3-0.1-0.5L7,33.5c-1.6-2.9-2.5-6.2-2.5-9.6	C4.5,13.2,13.3,4.5,24,4.5c5.2,0,10.1,2,13.8,5.7c3.7,3.7,5.7,8.6,5.7,13.8c0,10.7-8.7,19.5-19.5,19.5c-3.2,0-6.3-0.8-9.1-2.3	L5,43.8C5,43.8,4.9,43.8,4.9,43.8z"></path><path fill="#cfd8dc" d="M24,5c5.1,0,9.8,2,13.4,5.6C41,14.2,43,18.9,43,24c0,10.5-8.5,19-19,19h0c-3.2,0-6.3-0.8-9.1-2.3	L4.9,43.3l2.7-9.8C5.9,30.6,5,27.3,5,24C5,13.5,13.5,5,24,5 M24,43L24,43L24,43 M24,43L24,43L24,43 M24,4L24,4C13,4,4,13,4,24	c0,3.4,0.8,6.7,2.5,9.6L3.9,43c-0.1,0.3,0,0.7,0.3,1c0.2,0.2,0.4,0.3,0.7,0.3c0.1,0,0.2,0,0.3,0l9.7-2.5c2.8,1.5,6,2.2,9.2,2.2	c11,0,20-9,20-20c0-5.3-2.1-10.4-5.8-14.1C34.4,6.1,29.4,4,24,4L24,4z"></path><path fill="#40c351" d="M35.2,12.8c-3-3-6.9-4.6-11.2-4.6C15.3,8.2,8.2,15.3,8.2,24c0,3,0.8,5.9,2.4,8.4L11,33l-1.6,5.8	l6-1.6l0.6,0.3c2.4,1.4,5.2,2.2,8,2.2h0c8.7,0,15.8-7.1,15.8-15.8C39.8,19.8,38.2,15.8,35.2,12.8z"></path><path fill="#fff" fill-rule="evenodd" d="M19.3,16c-0.4-0.8-0.7-0.8-1.1-0.8c-0.3,0-0.6,0-0.9,0	s-0.8,0.1-1.3,0.6c-0.4,0.5-1.7,1.6-1.7,4s1.7,4.6,1.9,4.9s3.3,5.3,8.1,7.2c4,1.6,4.8,1.3,5.7,1.2c0.9-0.1,2.8-1.1,3.2-2.3	c0.4-1.1,0.4-2.1,0.3-2.3c-0.1-0.2-0.4-0.3-0.9-0.6s-2.8-1.4-3.2-1.5c-0.4-0.2-0.8-0.2-1.1,0.2c-0.3,0.5-1.2,1.5-1.5,1.9	c-0.3,0.3-0.6,0.4-1,0.1c-0.5-0.2-2-0.7-3.8-2.4c-1.4-1.3-2.4-2.8-2.6-3.3c-0.3-0.5,0-0.7,0.2-1c0.2-0.2,0.5-0.6,0.7-0.8	c0.2-0.3,0.3-0.5,0.5-0.8c0.2-0.3,0.1-0.6,0-0.8C20.6,19.3,19.7,17,19.3,16z" clip-rule="evenodd"></path>
                    </svg><span class="ml-3">Ödeme Planını Paylaş</span>
                </a>

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



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>




<!-- ARCHIVES JS -->
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    var errorMessage = "{{ session('error') }}";

    if (errorMessage) {
        Toastify({
            text: errorMessage,
            duration: 5000,
            gravity: 'bottom',
            position: 'center',
            backgroundColor: '#ff4d4d',
            stopOnFocus: true,
        }).showToast();
    }

    var successMessage = "{{ session('success') }}";

    if (successMessage) {
        Toastify({
            text: successMessage,
            duration: 5000,
            gravity: 'bottom',
            position: 'center',
            backgroundColor: 'green',
            stopOnFocus: true,
        }).showToast();
    }
</script>

<script>
    $(document).ready(function() {
        $('.listingDetailsSliderNav .item').on('mouseenter', function() {
            var totalSlides = $('#listingDetailsSlider .carousel-item')
                .length; // Toplam slayt sayısını al
            var slideNumber = $(this).find('a').attr('data-slide-to');
            $('.pagination .page-item-middle .page-link').text((slideNumber) + '/' +
                totalSlides); // Ortadaki li etiketinin metnini güncelle
            $('#listingDetailsSlider .carousel-inner .item').removeClass('active');
            $('#listingDetailsSlider .carousel-inner .item[data-slide-number="' + slideNumber + '"]')
                .addClass('active');
            $(this).css('border', '1px solid #EA2B2E'); // Border rengini kırmızı yap
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
            var slideNumber = $(this).attr('data-slide-to');
            $('#listingDetailsSlider .carousel-inner .item').removeClass('active');
            $('#listingDetailsSlider .carousel-inner .item[data-slide-number="' + slideNumber + '"]')
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
                    let modalContent =
                        '<div class="modal-header"><h3 class="modal-title fs-5" id="exampleModalLabel">Koleksiyona Ekle</h3></div><div class="modal-body collection-body">';

                    if (data.collections.length > 0) {
                        modalContent +=
                            '<span class="collectionTitle mb-3">Koleksiyonlarından birini seç veya yeni bir koleksiyon oluştur</span>';
                        modalContent +=
                            '<div class="collection-item-wrapper" id="selectedCollectionWrapper">';
                        modalContent +=
                            '<ul class="list-group" id="collectionList" style="justify-content: space-between;">';
                        data.collections.forEach(collection => {
                            modalContent +=
                                `<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important" data-collection-id="${collection.id}">${collection.name}</li>`;
                        });
                        modalContent +=
                            '<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important"><i class="fa fa-plus" style="color:#e54242;"></i> Yeni Ekle</li>';
                        modalContent += '</ul>';
                        modalContent += '</div>';
                    } else {
                        modalContent += '<p>Henüz koleksiyonun yok. Yeni koleksiyon oluştur:</p>';
                        modalContent +=
                            '<div class="collection-item-wrapper" id="selectedCollectionWrapper">';
                        modalContent +=
                            '<ul class="list-group" id="collectionList" style="justify-content: space-between;">';
                        modalContent +=
                            '<li class="list-group-item mb-3" style="cursor:pointer;color:black;font-size:11px !important"><i class="fa fa-plus" style="color:#e54242;"></i> Yeni Ekle</li>';
                        modalContent += '</ul>';
                        modalContent += '</div>';
                    }

                    modalContent +=
                        '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button></div>';
                    let modal = document.getElementById('addCollectionModal');
                    let modalBody = modal.querySelector('.modal-content');
                    modalBody.innerHTML = modalContent;

                    document.querySelectorAll('#collectionList li').forEach(item => {
                        item.addEventListener('click', function() {

                            let selectedCollectionId = this.getAttribute(
                                'data-collection-id');
                            if (!this.isEqualNode(document.querySelector(
                                    '#collectionList li:last-child'))) {

                                var cart = {
                                    id: productId, // productId nereden alındığını kontrol etmelisiniz
                                    type: type,
                                    project: project, // project nereden alındığını kontrol etmelisiniz
                                    _token: "{{ csrf_token() }}",
                                    clear_cart: "no",
                                    selectedCollectionId: parseInt(selectedCollectionId,
                                        10) // Convert to number using parseInt
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
        if (soldStatus == "1") {
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı',
                text: 'Bu ürün için ödeme detay bilgisi gösterilemiyor.',
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

                            html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                "' style='background-color: #EEE !important;' ><th style='text-align:center' class='paymentTableTitle' colspan=" +
                                (3 + parseInt(getDataJS(response, "pay-dec-count" + orderHousing,
                                    response.room_info[i].room_order), 10)) + " >" + response
                                .project_title +
                                " Projesinde " + block + " " + paymentOrder +
                                " No'lu İlan Ödeme Planı</th></tr>";


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
                                 

                                        var projectedEarningsData = "";
                                        var projectedEarnings = getDataJS(response, "projected_earnings[]", response.room_info[i].room_order);
                                        // var projectedEarnings = 10;
                                        var svgCode =
                                            '<svg viewBox="0 0 24 24" width="21" height="21" stroke="green" stroke-width="2" fill="green" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 7 23 12"></polyline></svg>';
                                        var projectedEarningsHTML = projectedEarnings ? svgCode +
                                            "<strong style='color:#28a745'> Öngörülen Yıllık Kazanç:</strong>" +
                                            "<span style='color:#28a745'> %" + projectedEarnings +
                                            "</span>" : "";

                                        projectedEarningsData += projectedEarningsHTML;
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
                                                            i].room_order)) - payDecPrice) /
                                                parseInt(installementData)) / numberOfShares) +
                                            "₺" : formatPrice((parseFloat(getDataJS(
                                                        response,
                                                        "installments-price[]", response
                                                        .room_info[i].room_order)) -
                                                    parseFloat(getDataJS(response,
                                                        "advance[]", response.room_info[
                                                            i].room_order)) - payDecPrice) /
                                                parseInt(installementData)) + "₺";
                                    }
                                    var isMobile = window.innerWidth < 768;

                                    orderHousing = parseInt(order);

                                    var payDecPrice = 0;
                                    if (paymentPlanDatax[paymentPlanData[j]] == "Taksitli") {
                                        html += "<tr class='" + (isMobile ? "mobile-hidden" : "") +
                                            "' style='background-color: #EEE !important;'><th>" +
                                            installementData +
                                            " Ay Taksitli Fiyat</th><th>Peşinat</th><th>Aylık Ödenecek Miktar</th>";

                                        for (var l = 1; l <= getDataJS(response,
                                                "pay-dec-count" + (orderHousing), response
                                                .room_info[i].room_order); l++) {
                                            html += "<th>" +
                                                l + ". Ara Ödeme</th>";
                                        }

                                        html += "</tr>";
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


                                            html += "<td>" + projectedEarningsData + "</td>";
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

                                        for (var l = 0; l < getDataJS(response,
                                                "pay-dec-count" + (orderHousing), response
                                                .room_info[i].room_order); l++) {

                                            if (getDataJS(response, "pay_desc_price" + (
                                                        orderHousing) + l, response.room_info[i]
                                                    .room_order)) {
                                                payDecPrice += parseFloat(getDataJS(response,
                                                    "pay_desc_price" + (orderHousing) +
                                                    l,
                                                    response.room_info[i].room_order));
                                                var payDescDate = new Date(getDataJS(response,
                                                    "pay_desc_date" + (orderHousing) +
                                                    l,
                                                    response.room_info[i].room_order));

                                                if (paymentPlanDatax[paymentPlanData[j]] ==
                                                    "Taksitli") {
                                                    html += "<td>" + (isMobile ? "<strong>" + (l +
                                                                1) +
                                                            ". Ara Ödeme :</strong> <br>" :
                                                            "") +
                                                        formatPrice(parseFloat(getDataJS(response,
                                                            "pay_desc_price" + (
                                                                orderHousing) + l, response
                                                            .room_info[
                                                                i]
                                                            .room_order))) + "₺" +
                                                        (isMobile ? " <br>" : "<br>") +
                                                        (months[payDescDate.getMonth()] + ' ' +
                                                            payDescDate.getDate() + ', ' +
                                                            payDescDate
                                                            .getFullYear()) + "</td>";
                                                } else {
                                                    html += null;
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

                            document.getElementById("whatsappButton").addEventListener("click", function() {
                            var projectSlug = response.slug + "-" + response.step2_slug + "-" +  response.housing_type.slug;
                            var projectID = response.id + 1000000;
                            var housingOrder = paymentOrder;
                            
                            var domain = window.location.hostname;
                            var url = domain + '/proje/' + projectSlug + '/ilan/' + projectID + '/' + housingOrder + '/detay' + "/odeme-plani";
                            
                          
                            // Whatsapp yönlendirme URL'sini oluştur
                            var whatsappURL = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(url);

                           
                           
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
                slidesToShow: 4.5,
                slidesToScroll: 5,
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

        checkFavorites();
        checkProjectFavorites();
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
                numbershare: parseInt(numbershare, 10), // Parse numbershare to an integer
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

                                toastr.error("Ürün Sepetten Kaldırılıyor.");
                                button.classList.remove("bg-success");
                                location.reload();

                            },
                            error: function(error) {
                                // window.location.href = "/giris-yap";

                                // console.error(error);
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


                                toastr.success("Ürün Sepete Eklendi");
                                if (!button.classList.contains("mobile")) {
                                    button.textContent = "Sepete Eklendi";
                                }
                                button.classList.add("bg-success");
                                window.location.href = "/sepetim";


                            },
                            error: function(error) {

                                window.location.href = "/giris-yap";

                                console.error(error);

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



        function checkProjectFavorites() {
            // Favorileri sorgula ve uygun renk ve ikonları ayarla
            var favoriteButtons = document.querySelectorAll(".toggle-project-favorite");
            var projectHousingPairs = []; // Proje ve housing ID'lerini içeren bir dizi

            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-project-housing-id");
                var projectId = button.getAttribute("data-project-id");

                projectHousingPairs.push({
                    projectId: projectId,
                    housingId: housingId
                });
            });
            var csrfToken = $('meta[name="csrf-token"]').attr('content');


            $.ajax({
                url: "{{ route('get.project.housing.favorite.status') }}",
                type: "POST",
                data: {
                    _token: csrfToken,
                    projectHousingPairs: projectHousingPairs
                },
                success: function(response) {
                    favoriteButtons.forEach(function(button) {
                        var housingId = button.getAttribute(
                            "data-project-housing-id");
                        var projectId = button.getAttribute("data-project-id");
                        var isFavorite = response[projectId][housingId];

                        if (isFavorite) {
                            button.querySelector("i").classList.remove(
                                "fa-heart-o");
                            button.querySelector("i").classList.add(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "text-danger");
                            button.classList.add("bg-white");
                        } else {
                            button.querySelector("i").classList.remove(
                                "text-danger");
                            button.querySelector("i").classList.remove(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "fa-heart-o");
                        }
                    });
                },
            });



        }


        function checkFavorites() {
            var favoriteButtons = document.querySelectorAll(".toggle-favorite");
            favoriteButtons.forEach(function(button) {
                var housingId = button.getAttribute("data-housing-id");

                $.ajax({
                    url: "{{ route('get.housing.favorite.status', ['id' => ':id']) }}"
                        .replace(':id', housingId),
                    type: "GET",
                    success: function(response) {
                        if (response.is_favorite) {
                            button.querySelector("i").classList.remove(
                                "fa-heart-o");
                            button.querySelector("i").classList.add(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "text-danger");
                            button.classList.add("bg-white");
                        } else {
                            button.querySelector("i").classList.remove(
                                "text-danger");
                            button.querySelector("i").classList.remove(
                                "fa-heart");
                            button.querySelector("i").classList.add(
                                "fa-heart-o");
                        }
                    },
                    error: function(error) {
                        button.querySelector("i").classList.remove(
                            "text-danger");
                        button.querySelector("i").classList.remove(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "fa-heart-o");
                        console.error(error);
                    }
                });
            });
        }



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
    const appUrl = "https://emlaksepette.com/"; // Uygulama URL'si
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
                        data.housings.forEach((e) => {
                            const imageUrl =
                                `${appUrl}housing_images/${e.photo}`; // Resim URL'sini uygulama URL'si ile birleştirin
                            const formattedName = e.name.charAt(0)
                                .toUpperCase() + e.name.slice(1);

                            //housign.show link eklenecek
                            $('.header-search-box').append(`
                          
                        `);

                        });
                    }

                    // Project search
                    if (data.projects.length > 0) {
                        hasResults = true;
                        $('.header-search-box').append(`
                                <div class="font-weight-bold p-2 small" style="background-color: #EEE;">PROJELER</div>
                            `);
                        data.projects.forEach((e) => {
                            console.log(e);
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
                            $('.header-search-box').append(`
                                            <a href="${baseRoute.replace('slug_placeholder', e.slug).replace('id_placeholder', e.id)}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                                <span>${formattedName}</span>
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
        const appUrl = "https://emlaksepette.com/"; // Uygulama URL'si
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
                                const formattedName = e.name.charAt(0)
                                    .toUpperCase() + e.name.slice(1);

                                //housign.show metodu eklenecek    
                                $('.header-search-box-mobile').append(`
                                  
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
