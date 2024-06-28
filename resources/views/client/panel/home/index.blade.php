@extends('client.layouts.master')
@section('content')

<section>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body text-center pb-xl-5 pt-xl-5">
                        <img class="mb-3" src="assets/images/icon/stores.png">
                        <br>
                        <h6>Mağazanıza Ürün Ekleyin</h6>
                        <h7 style="color:#999">Hemen mağazanıza yepyeni ürünler ekleyerek kısa sürede kazanç veya kazançlar sağlamaya başlayın</h7>
                        <br><br>
                        <a href="pages.php?page=products" class="btn btn-sm btn-success">YENİ ÜRÜN EKLE</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body text-center pb-xl-5 pt-xl-5">
                        <img class="mb-3" src="assets/images/icon/orders.png">
                        <br>
                        <h6>Siparişlerinize Göz Atın</h6>
                        <h7 style="color:#999">Müşterilerinizin siteniz üzerinden satın aldıkları ürünleri ve sipariş detaylarını inceleyin</h7>
                        <br><br>
                        <a href="pages.php?page=orders" class="btn btn-sm btn-success">TÜM SİPARİŞLER</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body text-center pb-xl-5 pt-xl-5">
                        <img class="mb-3" src="assets/images/icon/supp.png">
                        <br>
                        <h6>Destek Taleplerine Cevap Verin</h6>
                        <h7 style="color:#999">Müşterilerinizin her türlü soru veya sorunları için oluşturdukları destek taleplerine geri dönüş sağlayın</h7>
                        <br><br>
                        <a href="pages.php?page=tickets" class="btn btn-sm btn-success">TÜM DESTEK TALEPLERİ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</section>


@endsection

@section('scripts')
@endsection

@section('styles')
@endsection