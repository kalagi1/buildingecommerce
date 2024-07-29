@extends('client.layouts.masterPanel')
@section('content')
    <section>
        <div class="">
            <section id="header">
                <div class="container">
        
                    <div class="row mt-3">
                        <div class="col-md-12 ">
                            <div class="card shadow">
                                <ul class="nav nav-tabs justify-content-start">
                                    <li class="nav-item col-1">
                                        <a class="nav-link actived" href="index.php">Emlak</a>
                                    </li>
                                    <li class="nav-item col-1">
                                        <a class="nav-link" href="index.php">Projeler</a>
                                    </li>
                                </ul>
                            </div>
        
                        </div>
                    </div>
        
                </div>
            </section>
        
            <section id="content" class="mt-3 mb-5">
                <div class="container">
                    <div class="row mb-3">
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Alt Çalışan Sayısı</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Aktif İlanlar</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Onay Bekleyen İlanlar</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 pb-3">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Toplam İlan Sayısı</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Askıya Alınan İlanlar</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Koleksiyon Sayısı</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Görüntülenme Sayısı</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 ">
                            <div class="card" style="box-shadow: 0px 2px 5px 0px #0000001A;padding: 20px;border: 1px solid #ebebeb;background: white;">
                                <div class="d-flex flex-column">
                                    <div class="">Pazar Teklifleri</div>
                                    <div class=""><strong>22,000</strong></div>
                                    <div class="" style="color: #6B6B6B9E;">Son 1 Ayda</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="card shadow rounded" style="padding:10px;">
                                <div class="card-header" style="background-color:#FFFFFF;">
                                    <div class="row p-2">
                                        <h5 class="pl-2" style="border-left: 4px solid red;">Master Realtor Ayın Yıldızları</h5>
                                    </div>
                                </div>
                                <div class="table-responsive" style="background-color: white;">
                                    <table class="table m-0" style="background-color: white;">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Satışı Yapılan İlan Sayısı</th>
                                                <th scope="col">Toplam Kazanç</th>
                                                <th scope="col">Koleksiyon Satışları</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                                    <span class="badge text-small">Ahmet Koç</span>
                                                </td>
                                                <td>12000</td>
                                                <td>143,432.54</td>
                                                <td>143,432.54</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                                    <span class="badge text-small">Ahmet Koç</span>
                                                </td>
                                                <td>11000</td>
                                                <td>11000</td>
                                                <td>11000</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                                    <span class="badge text-small">Ahmet Koç</span>
                                                </td>
                                                <td>10000</td>
                                                <td>130,000.00</td>
                                                <td>130,000.00</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        
                        </div>
                        <div class="col-6">
                            <div class="shadow card rounded" style="height: 100%;padding:10px;">
                                <div class="card-header" style="background-color:#FFFFFF;">
                                    <div class="row p-2">
                                        <h5 class="pl-2" style="border-left: 4px solid red;">İstatistikler</h5>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <canvas id="statisticsChart"></canvas>
                                </div>
                            </div>
        
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <div class="d-flex flex-column" style="height: 100%;">
                                <div class="card mb-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
        
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="border-left: 4px solid red;">Emlak Sepette Ayın Kurumsal Üye 1.si</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="https://via.placeholder.com/50">
                                    </div>
                                </div>
                                <div class="card mt-1 mb-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
        
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="border-left: 4px solid red;">Emlak Sepette Ayın Kurumsal Üye 1.si</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="https://via.placeholder.com/50">
                                    </div>
                                </div>
                                <div class="card mt-1" style="height: 100%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
        
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="border-left: 4px solid red;">Emlak Sepette Ayın Kurumsal Üye 1.si</h5>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <img src="https://via.placeholder.com/50">
                                    </div>
                                </div>
                            </div>
        
                        </div>
                        <div class="col-4 ">
                            <div class="card" style="height: 100%;padding:10px">
                                <div class="d-flex flex-column" style="height: 100%;">
                                    <div class="p-2" style="height: 100%;">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <div class="fs-4">İlan Detayları</div>
                                                    <div class="fs-6">İlan Detayları</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-danger">İncele</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2" style="height: 100%;">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <div class="fs-4">İlan Detayları</div>
                                                    <div class="fs-6">İlan Detayları</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-danger">İncele</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2" style="height: 100%;">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <div class="fs-4">İlan Detayları</div>
                                                    <div class="fs-6">İlan Detayları</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-danger">İncele</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2" style="height: 100%;">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <div class="fs-4">İlan Detayları</div>
                                                    <div class="fs-6">İlan Detayları</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-danger">İncele</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-2" style="height: 100%;">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex flex-column">
                                                    <div class="fs-4">İlan Detayları</div>
                                                    <div class="fs-6">İlan Detayları</div>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <button type="button" class="btn btn-danger">İncele</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="d-flex flex-column" style="height: 100%;">
                                <div class="card shadow mb-1" style="height: 50%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="border-left: 4px solid red;">Satış İstatistikleri</h5>
                                        </div>
                                    </div>
        
                                    <div class="row">
                                        <div class="col-4">
                                            <canvas id="revenueChart"></canvas>
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex flex-column">
                                                <div class="p-2">Satış İstatistikleri</div>
                                                <div class="p-2">%123,4353</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow mt-1" style="height: 50%;padding:10px;">
                                    <div class="card-header" style="background-color:#FFFFFF;">
                                        <div class="row p-2">
                                            <h5 class="pl-2" style="border-left: 4px solid red;">Kira İstatistikleri</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
        
                                            <canvas id="salesChart"></canvas>
                                        </div>
                                        <div class="col-8">
                                            <div class="d-flex flex-column">
                                                <div class="p-2">Kira İstatistikleri</div>
                                                <div class="p-2">%123,4353</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="card shadow rounded" style="height: 100%;padding:10px;">
                                <div class="card-header p-3" style="background-color:#FFFFFF;">
                                    <div class="row p-2">
                                        <h5 class="pl-2" style="border-left: 4px solid red;">Satışı Yapılanlar</h5>
                                    </div>
                                </div>
                                <table class="table  m-0" style="height: 100%;">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img src="https://via.placeholder.com/40" alt="Ahmet Koç">
                                                <span class="badge ">Ahmet Koç</span>
                                            </td>
                                            <td>10000</td>
                                            <td>130,000.00</td>
                                            <td>130,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="https://via.placeholder.com/40" alt="Ahmet Koç">
                                                <span class="badge ">Ahmet Koç</span>
                                            </td>
                                            <td>10000</td>
                                            <td>130,000.00</td>
                                            <td>130,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="https://via.placeholder.com/40" alt="Ahmet Koç">
                                                <span class="badge ">Ahmet Koç</span>
                                            </td>
                                            <td>10000</td>
                                            <td>130,000.00</td>
                                            <td>130,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="https://via.placeholder.com/40" alt="Ahmet Koç">
                                                <span class="badge ">Ahmet Koç</span>
                                            </td>
                                            <td>10000</td>
                                            <td>130,000.00</td>
                                            <td>130,000.00</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <img src="https://via.placeholder.com/40" alt="Ahmet Koç">
                                                <span class="badge ">Ahmet Koç</span>
                                            </td>
                                            <td>10000</td>
                                            <td>130,000.00</td>
                                            <td>130,000.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end pt-3">
                                    <nav aria-label="Page navigation example ">
                                        <ul class="pagination">
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item">
                                                <a class="page-link" href="#" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 d-flex flex-column">
                            <div class="card shadow mb-2" style="height: 50%;">
                                <div class="d-flex flex-column" style="width: 100%;">
                                    <div class="d-flex justify-content-end m-0 pr-5">
                                        <h6 class=" "></h6>
                                    </div>
                                    <div class="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="p-4">
                                                        <img src="https://via.placeholder.com/40">
                                                    </div>
                                                    <div class="p-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="pt-3 pl-2">Toplam Kazancım</div>
                                                    <div class="pl-2 pt-1">2.301.102</div>
                                                </div>
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="view-more-link" style="color: #EA2B2E">
                                            Tamamını Gör <i class="fas fa-chevron-right view-more-icon" style="color: #EA2B2E"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow mb-2" style="height: 50%;">
                                <div class="d-flex flex-column" style="width: 100%;">
                                    <div class="d-flex justify-content-end m-0 pr-5">
                                        <h6 class=" "></h6>
                                    </div>
                                    <div class="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="p-4">
                                                        <img src="https://via.placeholder.com/40">
                                                    </div>
                                                    <div class="p-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="pt-3 pl-2">Son 30 Gün Kazancım</div>
                                                    <div class="pl-2 pt-1">458.637</div>
                                                </div>
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="view-more-link" style="color: #FF9907">
                                            Tamamını Gör <i class="fas fa-chevron-right view-more-icon" style="color: #FF9907"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow " style="height: 50%;">
                                <div class="d-flex flex-column" style="width: 100%;">
                                    <div class="d-flex justify-content-end m-0 pr-5">
                                        <h6 class=" "></h6>
                                    </div>
                                    <div class="" style="width: 100%;">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="p-4">
                                                        <img src="https://via.placeholder.com/40">
                                                    </div>
                                                    <div class="p-2"></div>
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="d-flex flex-column">
                                                    <div class="p-2"></div>
                                                    <div class="pt-3 pl-2">Emlak Kulüp Kazancım</div>
                                                    <div class="pl-2 pt-1">1.587.632</div>
                                                </div>
                                            </div>
                                            <div class="col-2"></div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <a href="#" class="view-more-link" style="color: #153D8C">
                                            Tamamını Gör <i class="fas fa-chevron-right view-more-icon"  style="color: #153D8C"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3" style="padding:10px;">
                        <div class="card-header" style="background-color:#FFFFFF;">
                            <div class="row">
                                <div class="col">
                                    <h5 class="pl-2 mt-2" style="border-left: 4px solid red;">Müşteriler</h5>
                                </div>
                                <div class="col-6">
                                </div>
                                <div class="col">
                                    <div class="d-flex justify-content-end">
                                        <div class="date-range-display">
                                            <i class="far fa-calendar-alt"></i>
                                            <span>20 Haz - 20 Tem</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table m-0">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Müşteri No</th>
                                    <th scope="col">Müşteri Adı</th>
                                    <th scope="col">Satın Alma Şekli</th>
                                    <th scope="col">İlandaki Fiyat</th>
                                    <th scope="col">Ödeme Durumu</th>
                                    <th scope="col">Satın Alma Tarihi</th>
        
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>#345454555</td>
                                    <td>
                                        <span><img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            <span class="badge text-small">Ahmet Koç</span></span>
                                    </td>
                                    <td>Emlak Kulüp</td>
                                    <td>1,423,242,335</td>
                                    <td>İade</td>
                                    <td>22.07.2024</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>#345454555</td>
                                    <td>
                                        <span><img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            <span class="badge text-small">Ahmet Koç</span></span>
                                    </td>
                                    <td>Emlak Kulüp</td>
                                    <td>1,423,242,335</td>
                                    <td>İade</td>
                                    <td>22.07.2024</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>#345454555</td>
                                    <td>
                                        <span><img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            <span class="badge text-small">Ahmet Koç</span></span>
                                    </td>
                                    <td>Emlak Kulüp</td>
                                    <td>1,423,242,335</td>
                                    <td>İade</td>
                                    <td>22.07.2024</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="" id=""></td>
                                    <td>#345454555</td>
                                    <td>
                                        <span><img src="https://via.placeholder.com/60" alt="Ahmet Koç">
                                            <span class="badge text-small">Ahmet Koç</span></span>
                                    </td>
                                    <td>Emlak Kulüp</td>
                                    <td>1,423,242,335</td>
                                    <td>İade</td>
                                    <td>22.07.2024</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end  pt-3 pr-2">
                            <nav aria-label="Page navigation example pr-2">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </section>      
        </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-5o8GF3Euf0cMnxLvsZG6g0Iu/R6fybQ4yQvlkZ5KhA2Sy8Y02v65J1ueZMEt1C7F" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        const ctx1 = document.getElementById('statisticsChart').getContext('2d');
        const ctx2 = document.getElementById('salesChart').getContext('2d');
        const ctx3 = document.getElementById('revenueChart').getContext('2d');

        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran'],
                datasets: [{
                    label: 'Projeler',
                    data: [12, 19, 3, 5, 2, 3],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Satışlar', 'Kazanç'],
                datasets: [{
                    label: 'Satış İstatistikleri',
                    data: [12, 19],
                    backgroundColor: ['rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                }]
            },
            options: {
                responsive: true,
            }
        });

        new Chart(ctx3, {
            type: 'doughnut',
            data: {
                labels: ['Kâr', 'Zarar'],
                datasets: [{
                    label: 'Kazanç İstatistikleri',
                    data: [15, 5],
                    backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)'],
                    borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                }]
            },
            options: {
                responsive: true,
            }
        });
    </script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Buttonları seç
            const button1 = document.getElementById('button1');
            const button2 = document.getElementById('button2');


            // Buttonlara tıklama olaylarını ekle
            button1.addEventListener('click', function() {
                toggleActive(button1);
            });

            button2.addEventListener('click', function() {
                toggleActive(button2);
            });


            // Düğmeyi aktif veya pasif yapacak fonksiyon
            function toggleActive(button) {
                // Tüm düğmelerden 'active' sınıfını kaldır
                button1.classList.remove('active');
                button2.classList.remove('active');


                // Tıklanan düğmeye 'active' sınıfını ekle
                button.classList.add('active');

                console.log(button.id + " active");
            }
        });
    </script>

    <script>
        function openChart(chartId) {
            // Remove 'active' class from all chart buttons
            $('.chart-button').removeClass('active');

            // Add 'active' class to the clicked button
            $('#' + chartId + '-btn').addClass('active');

            // Hide all tab panes
            $('.tab-pane').removeClass('show active');

            // Show the corresponding tab pane
            $('#' + chartId).addClass('show active');

            // Optional: Render chart based on chartId
            renderChart(chartId);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options1 = {
                chart: {
                    type: 'line',
                    height: 350,
                    width: '100%',
                    toolbar: {
                        show: true
                    }
                },
                series: [{
                    name: 'Emlaklar',
                    data: {!! $monthlyCounts['countsListings'] !!},
                    color: '#FF0000' // İlk veri seti için renk
                }, 
                @if ($monthlyCounts['user']->type == 2 && $monthlyCounts['user']->corporate_type = 'Banka' && $monthlyCounts['user']->corporate_type = 'İnşaat Ofisi' )
                {
                    name: 'Projeler',
                    data: {!! $monthlyCounts['countsProjects'] !!},
                    color: '#007BFF' // İkinci veri seti için renk
                }
                @endif
            ],
                xaxis: {
                    categories: {!! $monthlyCounts['monthsListings'] !!},


                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        }
                    }
                }]
            };

            var chart1 = new ApexCharts(document.querySelector("#chart1Content"), options1);
            chart1.render();
        });



        document.addEventListener('DOMContentLoaded', function() {
            var options2 = {
                chart: {
                    type: 'line',
                    height: 350,
                    width: '100%',
                    toolbar: {
                        show: true
                    }
                },
                series: [

                    {
                        name: 'Emlak Koleksiyonu',
                        data: {!! $monthlyCollectionCounts['countsListings'] !!}, // Emlak koleksiyon verileri
                        color: '#FF0000'
                    },
                    @if ($monthlyCollectionCounts['user']->type == 2 && $monthlyCounts['user']->corporate_type = 'Banka' && $monthlyCounts['user']->corporate_type = 'İnşaat Ofisi')
                        {
                            name: 'Proje Koleksiyonu',
                            data: {!! $monthlyCollectionCounts['countsProjects'] !!}, // Proje koleksiyon verileri  
                            color: '#007BFF'
                        }
                    @endif
                ],
                xaxis: {
                    categories: {!! $monthlyCollectionCounts['months'] !!} // Ayların listesi
                },
                yaxis: {
                    title: {
                        text: ''
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: '100%'
                        }
                    }
                }]
            };

            var chart2 = new ApexCharts(document.querySelector("#chart2Content"), options2);
            chart2.render();
        });
    </script> --}}
@endsection

@section('styles')
    <style>
       a.actived {
            color: #EA2B2E !important; /* Yazı rengini kırmızı yap */
            text-decoration: none; /* Varsayılan alt çizgiyi kaldır */
            position: relative; /* Konumlandırma yapabilmek için */
        }

        a.actived::after {
            content: ''; /* İçerik kısmı boş */
            display: block; /* Bloğa dönüştür */
            height: 2px; 
            background: red; 
            position: absolute; /* Konumlandırma */
            bottom: 12px; /* Çizginin metnin altında olması için */
            left: 0; /* Soldan hizalama */
            width: 100%; /* Çizginin genişliği metinle aynı */
        }

       #logo {
        margin-right: 0px;
        }

        #logo {
        display: inline-block;
        margin-top: 1px;
        }

        .resized-image {
        width: 200px;
        height: auto;
        }

        .rectangular-search {
        border-radius: 0;
        }

        .btn {
        border-radius: 0;
        }

        .fa-circle {
        color: red;
        font-size: 5px;
        padding: 2px;
        }

        .link {
        text-decoration: none;
        color: white;
        }

        .link1 {
        text-decoration: none;
        color: black;
        }

        .list-group-item {
        border: none;
        background-color: black;
        font-size: small;
        }

        .home-top-banner {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        }

        .logo {
        width: 100%;
        padding: 0px;
        margin: 0px !important;
        margin-left: 50px !important;
        }

        li a {
        color: black;
        }

        li a:hover {
        color: red;
        }

        /* li a:active {
        color: orange;
        } */

        .nav-tabs .nav-link {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 50px;
            color: #000;
            margin-right: 5px;
            font-size: 12px;
        }

        .nav-tabs .nav-link:hover{
            border:none;
        }

        .flex-container {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px; /* Optional: Adds space between items */
        }

        .flex-item {
            background-color: #f1f1f1;
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            flex: 1;
        }

        body {
           background-color: #f8f9fa;
        }

  
        .card-header {
            background-color: #FFFFFF;
            border-bottom: 1px solid #FFFFFF;
        }

        .card-header h5 {
            margin: 0;
            font-weight: 600;
            padding-left: 10px;
        }

        .card-body h3 {
            font-size: 24px;
            margin: 0;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .date-range-display {
            display: inline-flex;
            align-items: center;
            padding: 0.5em 1em;
            border: 1px solid #ccc;
            border-radius: 0.25em;
        }
        .date-range-display i {
            margin-right: 0.5em;
        }   

        .view-more-link {
            font-weight: bold;
            margin-right: 15px;
            margin-top: 25px;
        }
        .view-more-link:hover {
            color: #FF4500; /* Koyu turuncu renk */
            text-decoration: underline;
        }
        .view-more-icon {
            color: #FF4500; /* Koyu turuncu renk */
        }

        .nav-link a{
            color: #000;
            font-weight: bold;
        }

        .nav-link a:hover{
            color: #FF4500; /* Koyu turuncu renk */
        }

        /* .nav-link a.active{
            color: #FF4500; 
        } */
    </style>
@endsection
