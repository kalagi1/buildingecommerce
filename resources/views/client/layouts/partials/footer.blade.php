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

                </div>
                @foreach ($widgetGroups as $widgetGroup)
                    <div class="col-sm-12 col-md-12 col-lg col-xl">
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
                                    @if ($p->slug != "bireysel-uyelik-sozlesmesi" && $p->slug != "kurumsal-uyelik-sozlesmesi")
                                    <li><a href="{{ url('sayfa/' . $p->slug) }}">{{ $p->title }}</a></li>
 
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

<div class="payment-plan-pop-up d-none">
    <div class="payment-plan-pop-back">

    </div>
    <div class="payment-plan-pop-content">
        <div class="payment-plan-pop-close-icon"><i class="fa fa-times"></i></div>

        <div class="my-properties">
            <table class="payment-plan table">
                <thead>
                    <tr>
                        <th>Ödeme Türü</th>
                        <th>Fiyat</th>
                        <th>Peşin Ödenecek Tutar</th>
                        <th>Aylık Ödenecek Tutar</th>
                        <th>Taksit Sayısı</th>
                    </tr>
                </thead>
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



<script>
    $('body').on('click', '.addCollection', function(event) {
        event.preventDefault();
        $(".modal-backdrop").show();

        var button = $(this);
        var productId = $(this).data("id");
        var project = null;
        var type = $(this).data("type");

        if ($(this).data("type") == "project") {
            project = $(this).data("project");
        }

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
                    '<div class="modal-header"><h3 class="modal-title fs-5" id="exampleModalLabel">Koleksiyona Ekle</h3></div><div class="modal-body">';

                if (data.collections.length > 0) {
                    modalContent +=
                        '<span class="collectionTitle mb-3">Koleksiyonlarından birini seç veya yeni bir koleksiyon oluştur</span>';
                    modalContent += '<div class="collection-item-wrapper" id="selectedCollectionWrapper">';
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
                    modalContent += '<div class="collection-item-wrapper" id="selectedCollectionWrapper">';
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

                        let selectedCollectionId = this.getAttribute('data-collection-id');
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
    });


    $('#saveNewCollectionBtn').on('click', function() {
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
                        if (response.room_info[i].name == "payment-plan[]" && response.room_info[i]
                            .room_order == parseInt(order) + 1) {
                            var paymentPlanData = JSON.parse(response.room_info[i].value);


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
                            for (var j = 0; j < paymentPlanData.length; j++) {

                                if (!tempPlans.includes(paymentPlanData[j])) {
                                    if (paymentPlanData[j] == "pesin") {
                                        var priceData = getDataJS(response, "price[]", response
                                            .room_info[i].room_order);
                                        var installementData = "-";
                                        var advanceData = "-";
                                        var monhlyPrice = "-";
                                    } else {
                                        var priceData = getDataJS(response, "installments-price[]",
                                            response.room_info[i].room_order);
                                        var installementData = getDataJS(response, "installments[]",
                                            response.room_info[i].room_order);
                                        var advanceData = formatPrice(getDataJS(response,
                                            "advance[]",
                                            response.room_info[i].room_order)) + "₺";
                                        console.log((parseFloat(getDataJS(response,
                                            "installments-price[]", response
                                            .room_info[
                                                i].room_order)) - parseFloat(getDataJS(
                                            response, "advance[]", response
                                            .room_info[i]
                                            .room_order))));
                                        var monhlyPrice = (formatPrice(((parseFloat(getDataJS(
                                                    response,
                                                    "installments-price[]", response
                                                    .room_info[i].room_order)) -
                                                parseFloat(
                                                    getDataJS(response, "advance[]",
                                                        response.room_info[i].room_order
                                                    ))) /
                                            parseInt(installementData)))) + '₺';
                                    }
                                    var isMobile = window.innerWidth < 768;
                                    html += "<tr>";

                                    // Function to check if the value is empty or not
                                    function isNotEmpty(value) {
                                        return value !== "" && value !== undefined && value !==
                                            "-" &&
                                            value !== null;
                                    }

                                    if (!isMobile && isNotEmpty(paymentPlanDatax[paymentPlanData[
                                            j]])) {
                                        html += "<td>" + (isMobile ?
                                            "<strong>Ödeme Türü:</strong> " :
                                            "") + paymentPlanDatax[paymentPlanData[j]] + "</td>";
                                    }

                                    if (!isMobile || isNotEmpty(formatPrice(priceData))) {
                                        html += "<td>" + (isMobile ? paymentPlanDatax[
                                                paymentPlanData[
                                                    j]] + " " + "<strong>Fiyat:</strong> " : "") +
                                            formatPrice(priceData) + "₺</td>";
                                    }


                                    if (!isMobile || isNotEmpty(advanceData)) {
                                        html += "<td>" + (isMobile ? "<strong>Peşinat:</strong> " :
                                            "") + advanceData + "</td>";
                                    }

                                    if (!isMobile || isNotEmpty(monhlyPrice)) {
                                        html += "<td>" + (isMobile ?
                                                "<strong>Aylık Ödenecek Tutar:</strong> " : "") +
                                            monhlyPrice + "</td>";
                                    }


                                    if (!isMobile || isNotEmpty(installementData)) {
                                        html += "<td>" + (isMobile ?
                                                "<strong>Taksit Sayısı:</strong> " : "") +
                                            installementData + "</td>";
                                    }

                                    html += "</tr>";
                                }

                                tempPlans.push(paymentPlanData[j])

                            }

                            $('.payment-plan tbody').html(html);

                            $('.payment-plan-pop-up').removeClass('d-none')
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
        autoplay: false,
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
            var project = null;

            if ($(this).data("type") == "project") {
                project = $(this).data("project");
            }


            var cart = {
                id: productId,
                type: $(this).data("type"),
                project: project,
                _token: "{{ csrf_token() }}",
                clear_cart: "no" // Varsayılan olarak sepeti temizleme işlemi yok
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
                                // location.reload();

                            },
                            error: function(error) {
                                window.location.href = "/giris-yap";
                                console.error(error);
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
            toastr.error("Paylaşıma kapalı ürünleri koleksiyonunuza ekleyemezsiniz.");
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

        $('body').on('click', '.toggle-project-favorite', function(event) {
            event.preventDefault();
            console.log("s");
            var button = event.target;
            console.log(button);
            var housingId = this.getAttribute("data-project-housing-id");
            var projectId = this.getAttribute("data-project-id");

            $.ajax({
                url: "{{ route('add.project.housing.to.favorites', ['id' => ':id']) }}"
                    .replace(':id',
                        housingId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    project_id: projectId,
                    housing_id: housingId
                },
                success: function(response) {
                    if (response.status === 'added') {
                        toastr.success("Konut Favorilere Eklendi");
                        button.querySelector("i").classList.remove(
                            "fa-heart-o");
                        button.querySelector("i").classList.add(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "text-danger");
                        button.classList.add("bg-white");
                    } else if (response.status === 'removed') {
                        toastr.warning(
                            "Konut Favorilerden Kaldırıldı");
                        button.querySelector("i").classList.remove(
                            "text-danger");
                        button.querySelector("i").classList.remove(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "fa-heart-o");
                    }
                },
                error: function(error) {
                    window.location.href = "/giris-yap";
                }
            });
        });

        $('body').on("click", ".toggle-favorite", function(event) {
            event.preventDefault();
            var housingId = this.getAttribute("data-housing-id");
            var button = this;
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
                        button.querySelector("i").classList.remove(
                            "fa-heart-o");
                        button.querySelector("i").classList.add(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "text-danger");
                        button.classList.add("bg-white");
                    } else if (response.status === 'removed') {
                        toastr.warning("Konut Favorilerden Kaldırıldı");
                        button.querySelector("i").classList.remove(
                            "text-danger");
                        button.querySelector("i").classList.remove(
                            "fa-heart");
                        button.querySelector("i").classList.add(
                            "fa-heart-o");
                    }
                },
                error: function(error) {
                    window.location.href = "/giris-yap";
                    console.error(error);
                }
            });
        });

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

                            $('.header-search-box').append(`
                            <a href="{{ route('housing.show', '') }}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
                                <span>${formattedName}</span>
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
                        data.projects.forEach((e) => {
                            console.log(e);
                            const imageUrl =
                                `${appUrl}${e.photo.replace('public', 'storage')}`; // Resim URL'sini uygulama URL'si ile birleştirin
                            const formattedName = e.name.charAt(0)
                                .toUpperCase() + e.name.slice(1);
                                        // Assuming you have a JavaScript variable like this:
                                        var baseRoute = "{{ route('project.detail', ['slug' => 'slug_placeholder', 'id' => 'id_placeholder']) }}";

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
                                    <a href="{{ route('instituional.dashboard', '') }}/${e.slug}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
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

                                $('.header-search-box-mobile').append(`
                                    <a href="{{ route('housing.show', '') }}/${e.id}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
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
                                    "{{ route('project.detail', ['slug' => 'slug_placeholder', 'id' => 'id_placeholder']) }}";

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

                                $('.header-search-box-mobile').append(`
                                    <a href="{{ route('instituional.dashboard', '') }}/${e.slug}" class="d-flex text-dark font-weight-bold align-items-center px-3 py-1" style="gap: 8px;">
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
