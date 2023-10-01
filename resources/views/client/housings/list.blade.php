@extends('client.layouts.master')

@php
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
@endphp

@section('content')
    <div class="brand-head" style="margin-top: 20px;">

        <section class="properties-right list featured portfolio blog  bg-white">
            <div class="container">

                <div class="row project-filter-reverse">
                    <aside class="col-lg-3 col-md-12 car">
                        <div class="widget">
                            <!-- Search Fields -->
                            <div class="widget-boxed main-search-field">
                                <div class="widget-boxed-header">
                                    <h4>Filtrele</h4>
                                </div>
                                <!-- Search Form -->
                                <div class="trip-search">
                                    <form class="form filter-form" method="get">
                                        <!-- Form Lookin for -->
                                        <div class="form-group looking">
                                            <div class="first-select wide">
                                                <div class="main-search-input-item">
                                                    <input type="text" value="{{request('search')}}" name="search" placeholder="Ara..." value="" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group location" style="margin-top:40px;">
                                            <select name="city" class="form-control" id="">
                                                <option value="">İl Seç</option>
                                                @foreach($cities as $city)
                                                    <option @if(request('city') && request('city') == $city->id) selected @endif value="{{$city->id}}">{{$city->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group location">
                                            <select name="housing_type" class="form-control" id="">
                                                <option value="">Konut Tipi Seç</option>
                                                @foreach($housingTypes as $housingType)
                                                    <option @if(request('housing_type') && request('housing_type') == $housingType->id) selected @endif value="{{$housingType->id}}">{{$housingType->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group location">
                                            <select name="room_count" class="form-control" id="">
                                                <option disabled="null" selected="null">Oda Sayısı</option>
                                                <option>Hepsi</option>
                                                <option @if(request('room_count') && request('room_count') == "1+0") selected @endif value="1+0">1+0</option>
                                                <option @if(request('room_count') && request('room_count') == "1+1") selected @endif value="1+1">1+1</option>
                                                <option @if(request('room_count') && request('room_count') == "2+1") selected @endif value="2+1">2+1</option>
                                                <option @if(request('room_count') && request('room_count') == "2+2") selected @endif value="2+2">2+2</option>
                                                <option @if(request('room_count') && request('room_count') == "3+1") selected @endif value="3+1">3+1</option>
                                                <option @if(request('room_count') && request('room_count') == "3+2") selected @endif value="3+2">3+2</option>
                                                <option @if(request('room_count') && request('room_count') == "4+0") selected @endif value="4+0">4+0</option>
                                                <option @if(request('room_count') && request('room_count') == "4+1") selected @endif value="4+1">4+1</option>
                                                <option @if(request('room_count') && request('room_count') == "4+2") selected @endif value="4+2">4+2</option>
                                                <option @if(request('room_count') && request('room_count') == "5+0") selected @endif value="5+0">5+0</option>
                                                <option @if(request('room_count') && request('room_count') == "5+1") selected @endif value="5+1">5+1</option>
                                                <option @if(request('room_count') && request('room_count') == "5+2") selected @endif value="5+2">5+2</option>
                                            </select>
                                        </div>


                                        <div class="main-search-field-2">
                                            <!-- Area Range -->
                                            <div class="range-slider">
                                                <label>Net Metrekare</label>
                                                <div id="area-range" min-val="{{request('min-square-meters',"0")}}" max-val="{{request('max-square-meters',"1300")}}" data-min="0" data-max="1300"></div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <br>
                                            <!-- Price Range -->
                                            <div class="range-slider">
                                                <label>Fiyat Aralığı</label>
                                                <div id="price-range" min-val="{{request('min-price',"0")}}" max-val="{{request('max-price',"2600000")}}" data-min="0" data-max="2600000" data-unit="$"></div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>

                                        <!-- More Search Options / End -->
                                        <div class="col-lg-12 no-pds">
                                            <div class="at-col-default-mar">
                                                <button class="btn btn-default hvr-bounce-to-right" type="submit">Search</button>
                                            </div>
                                        </div>
                                        <!--/ End Form Bathrooms -->
                                    </form>
                                </div>
                                <!--/ End Search Form -->
                                <!-- Price Fields -->

                            </div>
                            <!-- <div class="widget-boxed mt-5">
                                            <div class="widget-boxed-header">
                                                <h4>Recent Properties</h4>
                                            </div>
                                            <div class="widget-boxed-body">
                                                <div class="recent-post">
                                                    <div class="recent-main">
                                                        <div class="recent-img">
                                                            <a href="blog-details.html"><img
                                                                    src="images/feature-properties/fp-1.jpg" alt=""></a>
                                                        </div>
                                                        <div class="info-img">
                                                            <a href="blog-details.html">
                                                                <h6>Family Modern Home</h6>
                                                            </a>
                                                            <p>$230,000</p>
                                                        </div>
                                                    </div>
                                                    <div class="recent-main my-4">
                                                        <div class="recent-img">
                                                            <a href="blog-details.html"><img
                                                                    src="images/feature-properties/fp-2.jpg" alt=""></a>
                                                        </div>
                                                        <div class="info-img">
                                                            <a href="blog-details.html">
                                                                <h6>Luxury Villa House</h6>
                                                            </a>
                                                            <p>$120,000</p>
                                                        </div>
                                                    </div>
                                                    <div class="recent-main">
                                                        <div class="recent-img">
                                                            <a href="blog-details.html"><img
                                                                    src="images/feature-properties/fp-3.jpg" alt=""></a>
                                                        </div>
                                                        <div class="info-img">
                                                            <a href="blog-details.html">
                                                                <h6>Luxury Family Home</h6>
                                                            </a>
                                                            <p>$150,000</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                        </div>
                    </aside>
                    <div class="col-lg-9 col-md-12 blog-pots">
                        <div class="row project-detalist-list" style="display: flex;justify-content: space-between;">
                            <h3 style="padding: 17px;">Daireler</h3>
                            <div style="display: flex; float: right;">
                                <select>
                                    <option selected>Sıralama</option>
                                    <option value="Fiyata Göre">Fiyata Göre</option>
                                    <option value="Tarihe Göre">Tarihe Göre</option>
                                </select>
                            </div>
                        </div>
                        @php
                            function getData($housing, $key)
                            {
                                $housing_type_data = json_decode($housing->housing_type_data);
                                $a = $housing_type_data->$key;
                                return $a[0];
                            }

                            function getImage($housing, $key)
                            {
                                $housing_type_data = json_decode($housing->housing_type_data);
                                $a = $housing_type_data->$key;
                                return $a;
                            }
                        @endphp
                        <div class="slick-agentsx row">
                            @foreach ($housings as $housing)
                                <div class="agents-grid col-md-4" data-aos="fade-up" data-aos-delay="150">
                                    <div class="landscapes">
                                        <div class="project-single">
                                            <div class="project-inner project-head">
                                                <div class="homes">
                                                    <!-- homes img -->
                                                    <a href="single-property-1.html" class="homes-img">
                                                        <img src="{{ asset('housing_images/' . getImage($housing, 'image')) }}"
                                                            alt="{{ $housing->housing_type_title }}"
                                                            class="img-responsive">
                                                    </a>
                                                </div>
                                                <div class="button-effect">
                                                    <!-- Örneğin Kalp İkonu -->
                                                    <a href="#" class="btn toggle-favorite"
                                                        data-housing-id="{{ $housing->id }}">
                                                        <i class="fa fa-heart"></i>
                                                    </a>

                                                </div>
                                            </div>
                                            <!-- homes content -->
                                            <div class="homes-content p-3" style="padding:20px !important">
                                                <!-- homes address -->
                                                <h3><a
                                                        href="{{ route('housing.show', $housing->id) }}">{{ $housing->title }}</a>
                                                </h3>
                                                <p class="homes-address mb-3">
                                                    <a href="{{ route('housing.show', $housing->id) }}">
                                                        <i
                                                            class="fa fa-map-marker"></i><span>{{ $housing->address }}</span>
                                                    </a>
                                                </p>
                                                <!-- homes List -->
                                                <ul class="homes-list clearfix pb-0"
                                                    style="display: flex;justify-content:space-between">
                                                    <li class="sude-the-icons" style="width:auto !important">
                                                        <i class="flaticon-bed mr-2" aria-hidden="true"></i>
                                                        <span>{{ $housing->housing_type->title }} </span>
                                                    </li>
                                                    <li class="sude-the-icons" style="width:auto !important">
                                                        <i class="flaticon-bathtub mr-2" aria-hidden="true"></i>
                                                        <span>{{ getData($housing, 'room_count') }}</span>
                                                    </li>
                                                    <li class="sude-the-icons" style="width:auto !important">
                                                        <i class="flaticon-square mr-2" aria-hidden="true"></i>
                                                        <span>{{ getData($housing, 'squaremeters') }} m2</span>
                                                    </li>
                                                </ul>
                                                <ul class="homes-list clearfix pb-0"
                                                    style="display: flex; justify-content: space-between;margin-top:20px !important;">
                                                    <li style="font-size: large; font-weight: 700;">
                                                        {{ getData($housing, 'price') }}TL</li>

                                                    <li style="display: flex; justify-content: center;">
                                                        {{ date('j', strtotime($housing->created_at)) . ' ' . convertMonthToTurkishCharacter(date('F', strtotime($housing->created_at))) }}
                                                    </li>
                                                </ul>
                                                <ul class="homes-list clearfix pb-0"
                                                    style="display: flex; justify-content: center;margin-top:20px !important;">
                                                    <button class="addToCart"
                                                        style="width: 100%; border: none; background-color: #446BB6; border-radius: 10px; padding: 5px 0px; color: white;"
                                                        data-type='housing' data-id='{{ $housing->id }}'>Sepete
                                                        Ekle</button>

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach







                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    {{-- <script>
        $(document).ready(function() {
            checkFavorites();
            var cart = @json(session('cart', []));
            // Sayfa yüklendiğinde düğme metnini güncellemek için bir işlev çağırın
            updateCartButton();

            // Tüm "Sepete Ekle" düğmelerini seçin
            var addToCartButtons = document.querySelectorAll(".addToCart");

            // Her düğmeye tıklanma olayını dinleyin
            addToCartButtons.forEach(function(button) {
                button.addEventListener("click", function() {
                    var productId = button.getAttribute("data-id");

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
                        button.disabled = true;
                        button.classList.add("bg-success");

                    } else {
                        button.textContent = "Sepete Ekle";
                        button.disabled = false;
                        button.classList.remove("bg-success");

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

        });
    </script> --}}
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
@endsection
