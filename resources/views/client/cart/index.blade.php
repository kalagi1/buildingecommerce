@extends('client.layouts.master')

@section('content')
    @php
        if (!$cart) {
            $cart['item'] = [
                'title' => '',
                'price' => '',
                'image' => '',
                'city' => '',
                'address' => '',
            ];
        }
    @endphp
    <section class="container justify-content-center">
        <div class="sude">
            <div class="content-sec col-lg-12 pt-5">

                <div class="row">
                    <div class="content-sec-box d-flex">

                        <div class="col-lg-8 col-md-12 col-sm-12 mr-5 mb-5 main-div">
                            <div class="row">
                                <div class="title-top mb-3 ml-1">
                                    <h4>Sepetim (1 ürün)</h4>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 special-div-left-bottom mt-3"
                                    style="padding: 0px !important;">

                                    <div class="header d-flex col-lg-12" style="background-color: rgb(226, 226, 226);">
                                        <input type="checkbox" id="checkk" class="mt-3">
                                        <label for="checkk">
                                            <h6 class="mt-3" style="margin-left: 30px;color: #446BB6;">
                                                {{ $cart['item']['title'] }}
                                            </h6>
                                        </label>

                                    </div>

                                    <div class="col-lg-12 image-content col-lg-12 pt-3 pb-3">
                                        <input type="checkbox" id="checkk" style="width: 1.5em; height: 1.5em;"
                                            class="special-checkbox-hide hiddeninput">
                                        <div class="col-lg-4">
                                            <img src="{{ $cart['item']['image'] }}" alt="" height="120px">
                                        </div>
                                        <div>
                                            <p style="font-size: 14px;color: #446BB6; ">
                                                {{ $cart['item']['city'] }}/{{ $cart['item']['address'] }}
                                            </p>
                                            <p>{{ $cart['item']['title'] }}</p>
                                        </div>
                                        <div class="col-lg-3 d-flex justify-content-center">
                                            <div style="border:1px solid #b1b1b1; display: flex;">
                                                <button
                                                    style="border: 1px solid rgb(223, 223, 223); margin: 0px !important;"
                                                    id="increment-btn">
                                                    +</button>
                                                <div id="counter-value" style="padding:0px 5px"> 0 </div>

                                                <button id="decrement-btn"
                                                    style="border: 1px solid rgb(223, 223, 223); margin: 0px !important;">-</button>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 special-div-left ">
                                    <h6>İlgilenebileceğiniz İlanlar</h6>
                                    <div class="col-lg-12 col-md-12 col-sm-12 images d-flex"
                                        style="padding: 0px !important;">
                                        <img src="./assets/img/i.png" alt="" height="140px" class="m-1">
                                        <img src="./assets/img/i.png" alt="" height="140px" class="m-1">
                                        <img src="./assets/img/i.png" alt="" height="140px" class="m-1">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 special-div-right">
                                    <h4>Sipariş Özeti</h4>
                                    <div class="order-info-payment">
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Ürünün toplamı:</p>
                                            <p>280,000,000</p>
                                        </div>
                                        <div class="col-lg-12 d-flex justify-content-between">
                                            <p>Depozito Toplamı:</p>
                                            <p>10,000</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 d-flex justify-content-end mt-5">

                                        <p style="color: rgb(5, 5, 190);">{{ $cart['item']['price'] }} TL</p>
                                    </div>

                                </div>
                                <div class="col-lg-12 special-div-right-bottom mt-4">
                                    <div class="order-info-payment">
                                        <img src="./assets/img/home.png" alt="" height="90em">
                                    </div>
                                    <div class="warning mt-4 justify-content-center align-content-center">
                                        <h6 style="display: flex; justify-content: center;">Güvenlik Önerileri</h6>
                                        <p style="text-align: center;">Gayrimenkulu görmeden,
                                            hiçbir sebeple kapora ve
                                            benzeri bir ödeme
                                            gerçekleştirmeyin.</p>
                                    </div>

                                </div>
                                <button class="col-lg-12 mt-3 sudespecialbuttons">
                                    + İNDİRİM KODUNU GİR
                                </button>
                                <button id="createOrder" class="col-lg-12 mt-3 sudespecialbuttonsd">
                                    Sepeti Onayla >
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $("#createOrder").click(function() {
            // Sepete eklenecek verileri burada hazırlayabilirsiniz
           

            // Ajax isteği gönderme
            $.ajax({
                url: "{{ route('client.create.order') }}", // Sepete veri eklemek için uygun URL'yi belirtin
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                }, // Veriyi göndermek için POST kullanabilirsiniz, // Sepete eklemek istediğiniz ürün verilerini gönderin
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
    </script>
@endsection
