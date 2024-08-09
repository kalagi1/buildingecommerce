@extends('client.layouts.masterPanel')
@section('content')

<div class="content">
        <div class="table-breadcrumb mb-5">
            <ul>
                <li>Hesabım</li>
                <li>CRM</li>
                <li>Danışman Müşterileri</li>
            </ul>
        </div>
   
        <div class="mb-3" role="group" aria-label="Basic example" style="text-align: center">
            <a href="#" class="btn active" id="new-customers-btn">
                <span>Yeni Müşteriler ({{$customerCount}})</span>
            </a>
            <a href="#" class="btn" id="follow-up-customers-btn">
                <span>Dönüş Yapılacak Müşteriler ({{$geri_donus_yapilacak_musterilerCount}})</span>
            </a>
            <a href="#" class="btn" id="all-customers-btn">
                <span> Müşteriler ({{$tum_musterilerCount}})</span>
            </a>
            <a href="#" class="btn" id="favorite-customers-btn">
                <span>Favori Müşteriler ({{$favoriteCustomerCount}})</span>
            </a>
            <a href="#" class="btn" id="appointments-btn">
                <span>Randevular ({{$randevuCount}})</span>
            </a>
        </div>
    
        {{-- yeni Müşteriler --}}
        <div class="text-header" id="yeniMusteriler" style="border:1px solid #df3a3a;border-radius:7px;margin-top:20px;">    
            <div class="d-flex" style="justify-content: space-between;"> 
                <input type="text" id="search-input-yeni" placeholder="Ara..." class="search-input form-control" >
                <button id="btnMusteriEkle" data-bs-toggle="modal" data-bs-target="#musteriEklemeModal">Yeni Müşteri Ekle</button>  
            </div>

            <div class="project-table-content user-item">
                <ul style="gap: 20px" >
                    <li style="width: 0%;">No.</li>
                    <li style="width: 10%;">Ad Soyad</li>
                    <li style="width: 15%;">E-posta</li>
                    <li style="width: 10%;">Telefon</li>
                    <li style="width: 10%;">Meslek</li>
                    <li style="width: 10%;">Şehir</li>
                    <li style="width: 15%;">İlgilendiği Proje</li>
                    <li style="width: 20%;">İşlemler</li>
                </ul>
            </div>
            <div id="user-list-table-body-yeni"></div>    
            <div id="pagination-controls" class="d-flex" style="margin-top: 20px;justify-content: space-between !important;">
                <button id="prev-page" class="btn btn-primary" disabled>Önceki</button>
                <span id="page-info"></span>
                <button id="next-page" class="btn btn-primary">Sonraki</button>
            </div>
        </div>

        {{-- Geri Dönüş Yapılacak Müşteriler --}}
        <div class="content"id="geriDonusYapilacakMusteriler" style="display: none;">
            <div class="text-header" style="border:1px solid #df3a3a;border-radius:7px;margin-top:20px;" >
                <input type="text" id="search-input-geridonus" placeholder="Ara..." class="search-input form-control" >
            <div class="project-table-content user-item ">
                <ul style="gap: 20px" >
                    <li style="width: 0%;">No.</li>
                    <li style="width: 10%;">Ad Soyad</li>
                    <li style="width: 10%;">E-posta</li>
                    <li style="width: 10%;">Telefon</li>
                    <li style="width: 10%;">Meslek</li>
                    <li style="width: 10%;">Şehir</li>
                    <li style="width: 10%;">İlgilendiği Proje</li>
                    <li style="width: 30%;">İşlemler</li>
                </ul>
            </div>
            <div id="user-list-table-body-geridonus"></div>
            <div id="no-data-message" style="display: none;background:white;" class="project-table-content">
                Dönüş yapılacak müşteriniz bulunmamaktadır.
            </div>
            
            <div id="pagination-controls" class="d-flex" style="margin-top: 20px;justify-content: space-between !important;">
                <button id="prev-page2" class="btn btn-primary" disabled>Önceki</button>
                <span id="page-info2"></span>
                <button id="next-page2" class="btn btn-primary">Sonraki</button>
            </div>
            </div>
        </div>

        {{-- Tüm Müşteriler --}}
        <div class="container"id="tumMusteriler" style="display: none;">
            <div class="text-header" style="border:1px solid #df3a3a;border-radius:7px;margin-top:20px;" >
                <input type="text" id="search-input-musteriler" placeholder="Ara..." class="search-input form-control" >
                <div class="project-table-content user-item">
                    <ul style="gap: 20px">
                        <li style="width: 0%;">No.</li>
                        <li style="width: 10%;">Ad Soyad</li>
                        <li style="width: 10%;">Telefon</li>
                        <li style="width: 10%;">İlgilendiği Proje</li>
                        <li style="width: 10%;">Görüşme Türü</li>
                        <li style="width: 10%;">Görüşme Sonucu</li>
                        <li style="width: 10%;">Görüşme Durumu</li>
                        <li style="width: 20%;">İşlemler</li>
                    </ul>
                </div>
                <div id="user-list-table-body-musteriler"></div>
                <div id="no-data-message-customers" style="display: none;background:white;" class="project-table-content">
                  Müşteriniz bulunmamaktadır.
                </div>
                <div id="pagination-controls" class="d-flex" style="margin-top: 20px;justify-content: space-between !important;">
                    <button id="prev-page3" class="btn btn-primary" disabled>Önceki</button>
                    <span id="page-info3"></span>
                    <button id="next-page3" class="btn btn-primary">Sonraki</button>
                </div>
            </div>
        </div>

        {{-- favori Müşteriler --}}
        <div class="container" id="favoriMusteriler" style="display: none">
            <div class="text-header" style="border:1px solid #df3a3a;border-radius:7px;margin-top:20px;" > 
                <input type="text" id="search-input-favoriler" placeholder="Ara..." class="search-input form-control" >
                <div class="project-table-content user-item">
                    <ul style="gap: 20px" >
                        <li style="width: 0%;">No.</li>
                        <li style="width: 10%;">Ad Soyad</li>
                        <li style="width: 10%;">E-posta</li>
                        <li style="width: 10%;">Telefon</li>
                        <li style="width: 10%;">Meslek</li>
                        <li style="width: 10%;">Şehir</li>
                        <li style="width: 10%;">İlgilendiği Proje</li>
                        <li style="width: 20%;">İşlemler</li>
                    </ul>
                </div>

                <div id="user-list-table-body-favoriler"> 
                        {{-- @foreach ($favoriteCustomers as $key => $item)
                            <div class="project-table-content user-item">
                                <ul  style="gap: 20px" >
                                    <li style="width: 0%;">{{ $key + 1 }}</li>
                                    <li style="width: 10%; align-items: flex-start;">
                                        <span>{{ $item->name }}</span>
                                    </li>
                                    <li style="width: 10%; align-items: flex-start;">
                                        <span>{{ $item->email }}</span>
                                    </li>
                                    <li style="width: 10%; align-items: flex-start;">
                                        <span>{{ $item->phone }}</span>
                                    </li>
                                    <li style="width: 10%; align-items: flex-start;">
                                        <span>{{ $item->job_title }}</span>
                                    </li>
                                    <li style="width: 10%; align-items: flex-start;">
                                        <span>{{ $item->province }}</span>
                                    </li>
                                    <li style="width: 10%; align-items: flex-start;">
                                        <span>{{ $item->project_name }}</span>
                                    </li>
                                
                                    <li style="width: 20%; display: flex; gap: 5px; flex-direction: row;">
                                        <button class="action-btn" title="Kişi Kartı" onclick="fetchUserDetails({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#userModal">
                                            <i class="fas fa-user"></i>

                                        </button>
                                        @if ($item->parent_id)
                                            <button class="action-btn" title="Geçmiş Görüşmeler" onclick="fetchCustomerCalls({{ $item->parent_id }})" data-bs-toggle="modal" data-bs-target="#pastConversationsModal">
                                                <i class="fas fa-history"></i>
                                            </button>
                                        @endif
                                        @php
                                            $isFavorited = DB::table('favorite_customers')
                                            ->where('customer_id', $item->id)->where('danisman_id', Auth::id())
                                            ->exists();
                                        @endphp
                                        <button id="favorite-btn-{{ $item->id }}" class="{{ $isFavorited ? 'favorited' : 'not-favorited' }}" title="{{ $isFavorited ? 'Favori' : 'Favoriye Al' }}" onclick="toggleFavorite({{ $item->id }})">
                                            <i class="fas fa-heart"></i>
                                        </button>

                                        <button class="action-btn-blue" title="Yeni Görüşme Giriş" onclick="addNewCall({{ $item->id }})" data-bs-toggle="modal" data-bs-target="#newCallsModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <a href="https://wa.me/{{ str_replace('p:+', '', $item->phone) }}" target="_blank">
                                            <button class="whatsapp-btn" title="WhatsApp Web">
                                                <i class="fab fa-whatsapp"></i>
                                            </button>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach --}}    
                </div>
                <div id="no-data-message-favorite" class="project-table-content" style="display: none">
                    Favori müşteriniz bulunmamaktadır.

                </div>
                <div id="pagination-controls" class="d-flex" style="margin-top: 20px;justify-content: space-between !important;">
                    <button id="prev-page4" class="btn btn-primary" disabled>Önceki</button>
                    <span id="page-info4"></span>
                    <button id="next-page4" class="btn btn-primary">Sonraki</button>
                </div>
            </div>
        </div>

        {{-- Randevular --}}
        <div class="container" id="randevular" style="display: none">   

            {{-- Navbar benzeri danışman listesi --}}
            <div class="navbar mb-4 mt-1">
                <div class="container">
                    <ul class="nav">
                        @foreach($danismanlar as $danisman)
                        <li class="nav-item" style="margin-left:10px !important;">
                            <button type="button" class="btnDanisman" 
                            style="background-color: {{ $danismanRenkler[$danisman->id] }};width:100% !important; padding:10px !important;
                                border-color: {{ $danismanRenkler[$danisman->id] }};"
                            disabled>{{ $danisman->name }}</button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="text-header" style="border:1px solid #df3a3a;border-radius:7px;margin-top:20px;">
                <div id='calendar'></div>
            </div>
                
        </div>   

        <!-- #userModal -->
        <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-2" id="exampleModalLabel">Kişi Kartı</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-header" style="margin-bottom: 0px;padding:10px 20px;background-color:transparent;">
                        <p class="sales-consultants-heading">Müşteri Bilgileri</p>
                    </div>
                    <div class="modal-body">                                  

                            <div class="row mt-3 customerInfo" style="margin-right:0px; ">
                                <div class="col-md-6">
                                    <p><strong>Ad Soyad:</strong>  <span id="user-modal-name"></span> </p>
                                    <p><strong>E-mail:</strong>  <span id="user-modal-email"></span></p>
                                    <p><strong>Telefon:</strong>  <span id="user-modal-phone"></span></p>
                                </div> 
                                <div class="col-md-6">
                                    <p><strong>Şehir:</strong>  <span id="user-modal-province"></span></p>
                                    <p><strong>İlgilendiği Proje:</strong>  <span id="user-modal-ilgilendigi-proje"></span></p>
                                    <p><strong>Meslek:</strong>  <span id="user-modal-job-title"></span></p>
                                </div>
                            </div>
                                <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                    <div style="width: 100%">
                                        <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Konut Tercihi</label>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input " type="checkbox" id="checkbox1" value="Projeden Konut" style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox1" >Projeden Konut</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox2" value="Hazır Konut"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox2">Hazır Konut</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                    <div style="width: 100%">
                                        <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Varlık Yönetimi</label>
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input " type="checkbox" id="checkbox3" value="Yatırım" style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox3">Yatırım</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox4" value="Oturum"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox4">Oturum</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox5" value="Yatırım/Oturum"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox5">Yatırım/Oturum</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                    <div style="width: 100%">
                                        <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Müşterinin Bütçesi</label>
                                        <div class="row mt-3">
                                            <div class="col-md-4 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input " type="checkbox" id="checkbox6" value="0-500.000" style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox6">0-500.000</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox7" value="500.000-1.000.000"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox7">500.000-1.000.000</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox8" value="2.000.000-4.000.000"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox8">2.000.000-4.000.000</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox9" value="4.000.000-6.000.000"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox9">4.000.000-6.000.000</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-1">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="checkbox10" value="6.000.000 ve üzeri"  style="border-radius: 50%">
                                                    <label class="form-check-label ml-5" for="checkbox10">6.000.000 ve üzeri</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                    <div style="width: 100%">
                                        <label for="exampleFormControlTextarea1" class="form-label mb-3 checkbox-title" style="color:#2b2b2bf5 !important;">Müşterinin İlgilendiği Bölge</label>
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <div class="form-check">
                                                <select name="ilgilendigi_bolge" id="" class="form-control">
                                                    <option value="">Seçiniz</option>
                                                    <option value="Marmara">Marmara</option>
                                                    <option value="Doğu Anadolu">Doğu Anadolu</option>
                                                    <option value="İç Anadolu">İç Anadolu</option>
                                                    <option value="Karadeniz">Karadeniz</option>
                                                    <option value="Akdeniz">Akdeniz</option>
                                                    <option value="Trakya">Trakya</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                    </div>                     
                </div>    
                </div>
            </div>
        </div>

        <!-- #pastConversationsModal -->
        <div class="modal fade" id="pastConversationsModal" tabindex="-1" aria-labelledby="pastConversationsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-2" id="exampleModalLabel">Arama Kayıtları</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-header" style="margin-bottom: 0px;padding:10px 20px;background-color:transparent;">
                        <p class="sales-consultants-heading">Geçmiş Görüşme Bilgileri</p>
                    </div>
                    <div class="modal-body" id="past-conversations-body"> </div>     
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" style="width: 15%; border-radius: 4px !important;" data-bs-dismiss="modal">Kapat</button>               
                    </div> 
                </div>   

                </div>
        </div>

        <!-- #newCallsModal -->
        <div class="modal fade" id="newCallsModal" tabindex="-1" aria-labelledby="newCallsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-2" id="newCallsModalLabel">Arama Kaydı Oluştur</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">                               
                        <div class="row justify-content-between">
                            <form id="new-call-form" style="display: flex;">
                                @csrf
                                <div class="col-md-6">
                                        <div class="row mt-3 customerInfo">
                                            <p style="font-size:1.3rem !important;text-align:center;width:100%">Müşteri Bilgileri</p>

                                            <div class="col-md-5">
                                                <p><strong>Ad Soyad:</strong>  <span id="new-call-modal-name"></span> </p>
                                                <p><strong>E-mail:</strong>  <span id="new-call-modal-email"></span></p>
                                                <p><strong>Telefon:</strong>  <span id="new-call-modal-phone"></span></p>
                                            </div> 
                                            <div class="col-md-7">
                                                <p><strong>Şehir:</strong>  <span id="new-call-modal-province"></span></p>
                                                <p><strong>İlgilendiği Proje:</strong>  <span id="new-call-modal-ilgilendigi-proje"></span></p>
                                                <p><strong>Meslek:</strong>  <span id="new-call-modal-job-title"></span></p>
                                            </div>
                                        </div>
                                
                                        <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                            <div style="width: 100%">
                                                <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Konut Tercihi</label>
                                                <div class="row mt-3">
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input " type="checkbox"  name="konut_tercihi" id="checkbox11" value="Projeden Konut" style="border-radius: 50%">
                                                            <label class="form-check-label ml-5" for="checkbox11" >Projeden Konut</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"  name="konut_tercihi" id="checkbox12" value="Hazır Konut"  style="border-radius: 50%">
                                                            <label class="form-check-label ml-5" for="checkbox12">Hazır Konut</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"  name="konut_tercihi" id="checkboxArsa" value="Arsa"  style="border-radius: 50%">
                                                            <label class="form-check-label ml-5" for="checkboxArsa">Arsa</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                            <div style="width: 100%">
                                                <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Varlık Yönetimi</label>
                                                <div class="row mt-3">
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input " type="checkbox"  name="varlik_yonetimi" id="checkbox13" value="Yatırım" style="border-radius: 50%">
                                                            <label class="form-check-label ml-5" for="checkbox13">Yatırım</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="varlik_yonetimi" id="checkbox14" value="Oturum"  style="border-radius: 50%">
                                                            <label class="form-check-label ml-5" for="checkbox14">Oturum</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="varlik_yonetimi" id="checkbox15" value="Yatırım/Oturum"  style="border-radius: 50%">
                                                            <label class="form-check-label ml-5" for="checkbox15">Yatırım/Oturum</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                            <div style="width: 100%">
                                                <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Müşterinin Bütçesi</label>
                                                <div class="row mt-3">
                                                    <div class="col-md-6 mt-1">
                                                        <div class="form-check" style="padding-left: 0.25rem;">
                                                            <input class="form-check-input " type="checkbox" name="musterinin_butcesi" id="checkbox16" value="0-500.000" style="border-radius: 50%">
                                                            <label class="form-check-label" style="margin-left: 2rem !important" for="checkbox16">0-500.000</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <div class="form-check" style="padding-left: 0.25rem;">
                                                            <input class="form-check-input" type="checkbox" name="musterinin_butcesi" id="checkbox17" value="500.000-1.000.000"  style="border-radius: 50%">
                                                            <label class="form-check-label "style="margin-left: 2rem !important" for="checkbox17">500.000-1.000.000</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <div class="form-check" style="padding-left: 0.25rem;">
                                                            <input class="form-check-input" type="checkbox" name="musterinin_butcesi" id="checkbox18" value="2.000.000-4.000.000"  style="border-radius: 50%">
                                                            <label class="form-check-label "style="margin-left: 2rem !important" for="checkbox18">2.000.000-4.000.000</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <div class="form-check" style="padding-left: 0.25rem;">
                                                            <input class="form-check-input" type="checkbox" name="musterinin_butcesi" id="checkbox19" value="4.000.000-6.000.000"  style="border-radius: 50%">
                                                            <label class="form-check-label"style="margin-left: 2rem !important" for="checkbox19">4.000.000-6.000.000</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <div class="form-check" style="padding-left: 0.25rem;">
                                                            <input class="form-check-input" type="checkbox" name="musterinin_butcesi" id="checkbox20" value="6.000.000 ve üzeri"  style="border-radius: 50%">
                                                            <label class="form-check-label "style="margin-left: 2rem !important" for="checkbox20">6.000.000 ve üzeri</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                            <div style="width: 100%">
                                                <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Müşterinin İlgilendiği Bölge</label>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="form-check" style="padding-left: 0px !important;">
                                                        <select name="ilgilendigi_bolge" id="" class="form-control" style="1px solid rgb(199 198 198);border-radius:5px !important;">
                                                            <option value="">Seçiniz</option>
                                                            <option value="Marmara">Marmara</option>
                                                            <option value="Doğu Anadolu">Doğu Anadolu</option>
                                                            <option value="İç Anadolu">İç Anadolu</option>
                                                            <option value="Karadeniz">Karadeniz</option>
                                                            <option value="Akdeniz">Akdeniz</option>
                                                            <option value="Trakya">Trakya</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                
                                </div>
                                <div class="col-md-6">
                                    <div class="customerInfo mt-3">
                                        <p style="font-size:1.3rem !important;text-align:center;width:100%">Yeni Arama Kaydı Oluştur</p>
                                    
                                            <input type="hidden" name="user_id" id="user_id" value="{{Auth::id()}}">
                                            <input type="hidden" name="customer_id2" id="customer_id2">

                                        <div class="mt-3 mb-3 ">
                                            <label for="">Görüşme Türü</label>
                                            <select class="form-select" name="gorusme_turu" aria-label="Default select example" style="1px solid rgb(199 198 198);border-radius:5px !important;">
                                                <option selected>Seçiniz</option>
                                                <option value="Telefon Araması (Biz Aradık)">Telefon Araması (Biz Aradık)</option>
                                                <option value="Telefon Araması (Müşteri Aradı)">Telefon Araması (Müşteri Aradı)</option>
                                                <option value="Ziyaret (Yüz Yüze)">Ziyaret (Yüz Yüze)</option>
                                                <option value="Online Görüşme (Zoom)">Online Görüşme (Zoom)</option>
                                                <option value="E-mail">E-mail</option>
                                            </select>
                                        </div>

                                        <div class="mt-3 mb-3">
                                            <label for="">Müşteri Durumu</label>
                                            <select class="form-select" name="gorusme_durumu" aria-label="Default select example" style="1px solid rgb(199 198 198);border-radius:5px !important;">
                                                <option selected>Seçiniz</option>
                                                <option value="Olumsuz">Olumsuz</option>
                                                <option value="Ulaşılamadı">Ulaşılamadı</option>
                                                <option value="Hatalı Numara">Hatalı Numara</option>
                                                <option value="Nötr">Nötr</option>
                                                <option value="Olumlu">Olumlu</option>
                                                <option value="Sıcak Müşteri">Sıcak Müşteri</option>
                                                <option value="Opsiyon">Opsiyon</option>
                                                
                                            </select>
                                        </div>
                                        
                                        <div class="mt-3 mb-3">
                                            <label for="">Görüşme Sonucu</label>
                                            <select class="form-select" name="gorusme_sonucu" aria-label="Default select example" style="1px solid rgb(199 198 198);border-radius:5px !important;">
                                                <option selected>Seçiniz</option>
                                                <option value="Takip Edilecek">Takip Edilecek</option>
                                                <option value="Randevu (Zoom)">Randevu (Zoom) </option>
                                                <option value="Randevu (Yüz Yüze)">Randevu (Yüz Yüze)</option>
                                                <option value="Yeni Projelerde Aranacak">Yeni Projelerde Aranacak</option>
                                                <option value="Olumsuz">Olumsuz </option>                                                    
                                                <option value="Bir Daha Aranmayacak">Bir Daha Aranmayacak</option>                                                    
                                                <option value="Satış">Satış</option>                                                    
                                            </select>
                                        </div>
                                        <div class="mt-3 mb-3">
                                            <label class="mb-3" for="">Görüşme Değerlendirme</label>
                                            <div style="display: flex; flex-direction: row; align-items: center; gap: 15px; margin-left: 7px;">
                                                @php $rating = 0; @endphp
                                        
                                                <input type="hidden" id="ratingInput" name="rating" value="{{ $rating }}">
                                        
                                                @foreach(range(0, 4) as $index)
                                                    <div>
                                                        <a href="#" onclick="handleStarPress({{ $index }})">
                                                            <i id="star{{ $index }}" class="fa fa-star{{ $index < $rating ? '' : '-o' }}" style="font-size: 32px; color: {{ $index < $rating ? 'gold' : 'gray' }};"></i>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="mt-3 mb-3">
                                            <label class="mb-3" for="note">Görüşme Notu</label>
                                            <textarea style="height: 150px !important;1px solid rgb(199 198 198);border-radius:5px !important;" name="note" id="note" class="form-control" cols="30" rows="50"></textarea>
                                        </div>
                                        {{-- randevular tablosuna ekle --}}
                                        <div class="mt-3 mb-3">
                                            <label class="mb-3" for="randevu">Yeni Görüşme Tarihi</label>
                                            <input type="datetime-local" name="sonraki_gorusme_tarihi" id="" class="form-control" style="border-radius: 5px !important;">
                                        </div>                                                
                                        
                                        <div class="mt-3 mb-3">
                                            <label class="mb-3" for="note">Sonraki Görüşme Türü</label>
                                            <select class="form-select" name="sonraki_gorusme_turu" aria-label="Default select example" style="1px solid rgb(199 198 198);border-radius:5px !important;">
                                                <option selected>Seçiniz</option>
                                                <option value="Telefon">Telefon</option>
                                                <option value="Randevu (Zomm)">Randevu (Zoom)</option>
                                                <option value=">Randevu (Yüz Yüze)">Randevu (Yüz Yüze)</option>                                                   
                                            </select>
                                        </div>
                                        
                                        <div class="mt-3 mb-3">
                                            <label class="mb-3" for="note">Randevu Notu</label>
                                            <textarea style="height: 75px !important;1px solid rgb(199 198 198);border-radius:5px !important " name="randevu_notu" id="randevu_notu" class="form-control" cols="30" rows="50"></textarea>
                                        </div>
                                    
                                        </div>   
                                        <div class="col-12 mt-5 d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" style="width: 15%; border-radius: 4px !important;" data-bs-dismiss="modal">Kapat</button>
                                            <button class="btnSubmit" type="submit"  data-bs-dismiss="modal" style="width: 15%;margin-right:10px;">Kaydet</button>
                                        </div>                                         
                                </div>
                                
                            </form>
                        </div>      
                    </div>                     
                    </div>                           
                </div>
            </div>
        </div>

        {{-- #musteriEklemeModal --}}
        <div class="modal fade" id="musteriEklemeModal" tabindex="-1" aria-labelledby="musteriEklemeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fs-2" id="musteriEklemeModalLabel">Müşteri Ekle</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="text-header" style="margin-bottom: 0px;padding:10px 20px;background-color:transparent;">
                        <p class="sales-consultants-heading">Müşteri Bilgileri Giriniz</p>
                    </div>
                    <div class="modal-body">   
                        <form id="musteriEklemeForm"> 
                            @csrf
                            <div class="row mt-3 customerInfo" style="margin-right:0px; ">
                                <div class="col-md-12">
                                    <input type="text" name="name" placeholder="Ad Soyad" class="inputMusteriEkle">
                                    <input type="text" name="email" placeholder="E-mail" class="inputMusteriEkle">
                                    <input type="text" name="phone" placeholder="Telefon" class="inputMusteriEkle">
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="job_title" placeholder="Meslek" class="inputMusteriEkle">
                                    <input type="text" name="province" placeholder="Şehir" class="inputMusteriEkle">
                                    <select name="ilgilendigi_bolge" id="" class="form-control" style="1px solid rgb(199 198 198);border-radius:5px !important;">
                                        <option value="0">Seçiniz</option>
                                        @foreach ($danismanProjeleri as $item)
                                            <option value="{{$item->projectId}}">{{$item->project_title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                <div style="width: 100%">
                                    <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Konut Tercihi</label>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="konutProjeden" name="konut_tercihi" value="Projeden Konut" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="konutProjeden">Projeden Konut</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="konutHazir" name="konut_tercihi" value="Hazır Konut" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="konutHazir">Hazır Konut</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                <div style="width: 100%">
                                    <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Varlık Yönetimi</label>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="varlikYatirim" name="varlik_yonetimi" value="Yatırım" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="varlikYatirim">Yatırım</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="varlikOturum" name="varlik_yonetimi" value="Oturum" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="varlikOturum">Oturum</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="varlikYatirimOturum" name="varlik_yonetimi" value="Yatırım/Oturum" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="varlikYatirimOturum">Yatırım/Oturum</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                <div style="width: 100%">
                                    <label for="exampleFormControlTextarea1" class="form-label checkbox-title mb-3" style="color:#2b2b2bf5 !important;">Müşterinin Bütçesi</label>
                                    <div class="row mt-3">
                                        <div class="col-md-4 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="butce1" name="musteri_butcesi" value="0-500.000" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="butce1">0-500.000</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="butce2" name="musteri_butcesi" value="500.000-1.000.000" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="butce2">500.000-1.000.000</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="butce3" name="musteri_butcesi" value="2.000.000-4.000.000" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="butce3">2.000.000-4.000.000</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="butce4" name="musteri_butcesi" value="4.000.000-6.000.000" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="butce4">4.000.000-6.000.000</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="butce5" name="musteri_butcesi" value="6.000.000 ve üzeri" style="border-radius: 50%">
                                                <label class="form-check-label ml-5" for="butce5">6.000.000 ve üzeri</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2 customerInfo" style="padding:20px 30px;">
                                <div style="width: 100%">
                                    <label for="exampleFormControlTextarea1" class="form-label mb-3 checkbox-title" style="color:#2b2b2bf5 !important;">Müşterinin İlgilendiği Bölge</label>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <select name="ilgilendigi_bolge" id="" class="form-control">
                                                    <option value="">Seçiniz</option>
                                                    <option value="Marmara">Marmara</option>
                                                    <option value="Doğu Anadolu">Doğu Anadolu</option>
                                                    <option value="İç Anadolu">İç Anadolu</option>
                                                    <option value="Karadeniz">Karadeniz</option>
                                                    <option value="Akdeniz">Akdeniz</option>
                                                    <option value="Trakya">Trakya</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="col-12 mt-5 d-flex justify-content-between">
                                <button type="button" class="btn btn-secondary" style="width: 15%; border-radius: 4px !important;" data-bs-dismiss="modal">Kapat</button>
                                <button class="btnSubmit" type="submit" data-bs-dismiss="modal" style="width: 15%;margin-right:10px;">Kaydet</button>
                            </div>     
                        </form>    
                    </div>                     
                </div>    
            </div>
        </div>

@endsection    

@section('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
     <!-- SweetAlert2 JS -->
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
      
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/tr.js"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    {{-- //yeni müşteriler pagination --}}
    <script>
        $(document).ready(function() {
            const itemsPerPage = 10; // Her sayfada göstermek istediğiniz müşteri sayısı
            let currentPage = 1;
            const $list = $('#user-list-table-body-yeni');
            const $paginationControls = $('#pagination-controls');
            const $prevPage = $('#prev-page');
            const $nextPage = $('#next-page');
            const $pageInfo = $('#page-info');

            // Müşteri verilerinizi buraya JSON formatında yerleştirin
            const allCustomers = @json($customers); // Laravel Blade'den JSON olarak veri

            function renderPage(page) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedItems = allCustomers.slice(start, end);

                let html = '';
                paginatedItems.forEach((item, index) => {
                 
                    html += `
                        <div class="project-table-content user-item">
                            <ul style="gap: 20px">
                                <li style="width: 0%;">${start + index + 1}</li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.name}</span>
                                </li>
                                <li style="width: 15%; align-items: flex-start; word-wrap: break-word; word-break: break-all;">
                                    <span>${item.email}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.phone}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.job_title}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.province}</span>
                                </li>
                                <li style="width: 15%; align-items: flex-start;">
                                    <span>${item.project_name}</span>
                                </li>
                                <li style="width: 20%; display: flex; gap: 5px; flex-direction: row;">
                                    <button class="action-btn" title="Kişi Kartı" onclick="fetchUserDetails(${item.id})" data-bs-toggle="modal" data-bs-target="#userModal">
                                        <i class="fas fa-user"></i>
                                    </button>
                                    ${item.parent_id ? `
                                        <button class="action-btn" title="Geçmiş Görüşmeler" onclick="fetchCustomerCalls(${item.parent_id})" data-bs-toggle="modal" data-bs-target="#pastConversationsModal">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    ` : ''}
                                    <button id="favorite-btn-${item.id}" class="${item.isFavorited ? 'favorited' : 'not-favorited'}" title="${item.isFavorited ? 'Favori' : 'Favoriye Al'}" onclick="toggleFavorite(${item.id})">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button class="action-btn-blue" title="Yeni Görüşme Giriş" onclick="addNewCall(${item.id})" data-bs-toggle="modal" data-bs-target="#newCallsModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <a href="https://wa.me/${item.phone.replace('p:+', '')}" target="_blank">
                                        <button class="whatsapp-btn" title="WhatsApp Web">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    `;
                });

                $list.html(html);
                updatePaginationControls();
            }

            function updatePaginationControls() {
                const totalPages = Math.ceil(allCustomers.length / itemsPerPage);

                $prevPage.prop('disabled', currentPage === 1);
                $nextPage.prop('disabled', currentPage === totalPages);
                $pageInfo.text(`Sayfa ${currentPage} / ${totalPages}`);
            }

            $prevPage.on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $nextPage.on('click', function() {
                const totalPages = Math.ceil(allCustomers.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            // İlk sayfayı render et
            renderPage(currentPage);
        });
    </script>

    {{-- //dönüş yapılacak müşteriler --}}
    <script>
        $(document).ready(function() {
            const itemsPerPage = 10; // Her sayfada göstermek istediğiniz müşteri sayısı
            let currentPage = 1;
            const $list = $('#user-list-table-body-geridonus');
            const $paginationControls = $('#pagination-controls');
            const $prevPage = $('#prev-page2');
            const $nextPage = $('#next-page2');
            const $pageInfo = $('#page-info2');
            const $noDataMessage = $('#no-data-message');
            // Müşteri verilerinizi buraya JSON formatında yerleştirin
            const geri_donus_yapilacak_musteriler = @json($geri_donus_yapilacak_musteriler);
            // Eğer veri yoksa
            if (geri_donus_yapilacak_musteriler.length === 0) {
                            $noDataMessage.show(); // Boş veri mesajını göster
             
            }
            function renderPage(page) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedItems = geri_donus_yapilacak_musteriler.slice(start, end);
                let html = '';

                // Veri varsa
                $noDataMessage.hide(); // Boş veri mesajını gizle
                paginatedItems.forEach((item, index) => {
                let cleanedPhone = item.phone ? item.phone.replace(/^p:\+/, '') .replace(/^\+9/, '') .replace(/^9/, '') : '-';

                    html += `
                        <div class="project-table-content user-item">
                            <ul style="gap: 20px">
                                <li style="width: 0%;">${start + index + 1}</li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.name}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start; word-wrap: break-word; word-break: break-all;">
                                    <span>${item.email}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${cleanedPhone}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.job_title}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.province}</span>
                                </li>
                                <li style="width: 15%; align-items: flex-start;">
                                    <span>${item.project_name}</span>
                                </li>
                                <li style="width: 20%; display: flex; gap: 5px; flex-direction: row;">
                                    <button class="action-btn" title="Kişi Kartı" onclick="fetchUserDetails(${item.id})" data-bs-toggle="modal" data-bs-target="#userModal">
                                        <i class="fas fa-user"></i>
                                    </button>
                                    ${item.parent_id ? `
                                        <button class="action-btn" title="Geçmiş Görüşmeler" onclick="fetchCustomerCalls(${item.parent_id})" data-bs-toggle="modal" data-bs-target="#pastConversationsModal">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    ` : ''}
                                    <button id="favorite-btn-${item.id}" class="${item.isFavorited ? 'favorited' : 'not-favorited'}" title="${item.isFavorited ? 'Favori' : 'Favoriye Al'}" onclick="toggleFavorite(${item.id})">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button class="action-btn-blue" title="Yeni Görüşme Giriş" onclick="addNewCall(${item.id})" data-bs-toggle="modal" data-bs-target="#newCallsModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <a href="https://wa.me/${item.phone.replace('p:+', '')}" target="_blank">
                                        <button class="whatsapp-btn" title="WhatsApp Web">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    `;
                });

                $list.html(html);
                console.log(html)
                updatePaginationControls();
            }

            function updatePaginationControls() {
                const totalPages = Math.ceil(geri_donus_yapilacak_musteriler.length / itemsPerPage);

                $prevPage.prop('disabled', currentPage === 1);
                $nextPage.prop('disabled', currentPage === totalPages);
                $pageInfo.text(`Sayfa ${currentPage} / ${totalPages}`);
            }

            $prevPage.on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $nextPage.on('click', function() {
                const totalPages = Math.ceil(geri_donus_yapilacak_musteriler.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            // İlk sayfayı render et
            renderPage(currentPage);
        });
    </script>

    {{-- //tüm müşteriler --}}
    <script>       
        $(document).ready(function() {
            const itemsPerPage = 10; // Her sayfada göstermek istediğiniz müşteri sayısı
            let currentPage = 1;
            const $list = $('#user-list-table-body-musteriler');
            const $paginationControls = $('#pagination-controls');
            const $prevPage = $('#prev-page3');
            const $nextPage = $('#next-page3');
            const $pageInfo = $('#page-info3');
            const $noDataMessageCustomers = $('#no-data-message-customers');
            // Müşteri verilerinizi buraya JSON formatında yerleştirin
            const tumMusteriler = @json($tum_musteriler); 
            if (tumMusteriler.length === 0) {
                $noDataMessageCustomers.show();
            }

            function renderPage(page) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedItems = tumMusteriler.slice(start, end);

                let html = '';
                paginatedItems.forEach((item, index) => {
                    html += `
                        <div class="project-table-content user-item">
                            <ul style="gap: 20px">
                                <li style="width: 0%;">${start + index + 1}</li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.name}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.phone}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.project_name || '-'}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.gorusme_turu || '-'}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.gorusme_sonucu || '-'}</span>
                                </li>
                                <li style="width: 10%; align-items: flex-start;">
                                    <span>${item.gorusme_durumu || '-'}</span>
                                </li>
                                <li style="width: 20%; display: flex; gap: 5px; flex-direction: row;">
                                    <button class="action-btn" title="Kişi Kartı" onclick="fetchUserDetails(${item.id})" data-bs-toggle="modal" data-bs-target="#userModal">
                                        <i class="fas fa-user"></i>
                                    </button>
                                    ${item.parent_id ? `
                                        <button class="action-btn" title="Geçmiş Görüşmeler" onclick="fetchCustomerCalls(${item.parent_id})" data-bs-toggle="modal" data-bs-target="#pastConversationsModal">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    ` : ''}
                                    <button id="favorite-btn-${item.id}" class="${item.isFavorited ? 'favorited' : 'not-favorited'}" title="${item.isFavorited ? 'Favori' : 'Favoriye Al'}" onclick="toggleFavorite(${item.id})">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <button class="action-btn-blue" title="Yeni Görüşme Giriş" onclick="addNewCall(${item.id})" data-bs-toggle="modal" data-bs-target="#newCallsModal">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                    <a href="https://wa.me/${item.phone.replace('p:+', '')}" target="_blank">
                                        <button class="whatsapp-btn" title="WhatsApp Web">
                                            <i class="fab fa-whatsapp"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    `;
                });

                $list.html(html);
                updatePaginationControls();
            }

            function updatePaginationControls() {
                const totalPages = Math.ceil(tumMusteriler.length / itemsPerPage);

                $prevPage.prop('disabled', currentPage === 1);
                $nextPage.prop('disabled', currentPage === totalPages);
                $pageInfo.text(`Sayfa ${currentPage} / ${totalPages}`);
            }

            $prevPage.on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $nextPage.on('click', function() {
                const totalPages = Math.ceil(tumMusteriler.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            // İlk sayfayı render et
            renderPage(currentPage);
        });
    </script>

    {{-- //favorş müşteriler --}}
    <script>
        //favorş müşteriler
        $(document).ready(function() {
            const itemsPerPage = 10; // Her sayfada göstermek istediğiniz müşteri sayısı
            let currentPage = 1;
            const $list = $('#user-list-table-body-favoriler');
            const $paginationControls = $('#pagination-controls');
            const $prevPage = $('#prev-page4');
            const $nextPage = $('#next-page4');
            const $pageInfo = $('#page-info4');
            const $noDataMessageFavorite = $('#no-data-message-favorite');

            // Müşteri verilerinizi buraya JSON formatında yerleştirin
            const favoriteCustomers = @json($favoriteCustomers); 
            if (favoriteCustomers.length === 0) {
                $noDataMessageFavorite.show();
            }

            function renderPage(page) {
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const paginatedItems = favoriteCustomers.slice(start, end);

                let html = '';
                paginatedItems.forEach((item, index) => {
                    html += `
                    <div class="project-table-content user-item">
                        <ul style="gap: 20px">
                            <li style="width: 0%;">${start + index + 1}</li>
                            <li style="width: 10%; align-items: flex-start;">
                                <span>${item.name}</span>
                            </li>
                            <li style="width: 15%; align-items: flex-start; word-wrap: break-word; word-break: break-all;">
                                <span>${item.email}</span>
                            </li>
                            <li style="width: 10%; align-items: flex-start;">
                                <span>${item.phone}</span>
                            </li>
                            <li style="width: 10%; align-items: flex-start;">
                                <span>${item.job_title}</span>
                            </li>
                            <li style="width: 10%; align-items: flex-start;">
                                <span>${item.province}</span>
                            </li>
                            <li style="width: 15%; align-items: flex-start;">
                                <span>${item.project_name}</span>
                            </li>
                            <li style="width: 20%; display: flex; gap: 5px; flex-direction: row;">
                                <button class="action-btn" title="Kişi Kartı" onclick="fetchUserDetails(${item.id})" data-bs-toggle="modal" data-bs-target="#userModal">
                                    <i class="fas fa-user"></i>
                                </button>
                                ${item.parent_id ? `
                                    <button class="action-btn" title="Geçmiş Görüşmeler" onclick="fetchCustomerCalls(${item.parent_id})" data-bs-toggle="modal" data-bs-target="#pastConversationsModal">
                                        <i class="fas fa-history"></i>
                                    </button>
                                ` : ''}
                                <button id="favorite-btn-${item.id}" class="${item.isFavorited ? 'favorited' : 'not-favorited'}" title="${item.isFavorited ? 'Favori' : 'Favoriye Al'}" onclick="toggleFavorite(${item.id})">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="action-btn-blue" title="Yeni Görüşme Giriş" onclick="addNewCall(${item.id})" data-bs-toggle="modal" data-bs-target="#newCallsModal">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <a href="https://wa.me/${item.phone.replace('p:+', '')}" target="_blank">
                                    <button class="whatsapp-btn" title="WhatsApp Web">
                                        <i class="fab fa-whatsapp"></i>
                                    </button>
                                </a>
                            </li>
                        </ul>
                    </div>
                    `;
                });

                $list.html(html);
                updatePaginationControls();
            }

            function updatePaginationControls() {
                const totalPages = Math.ceil(favoriteCustomers.length / itemsPerPage);

                $prevPage.prop('disabled', currentPage === 1);
                $nextPage.prop('disabled', currentPage === totalPages);
                $pageInfo.text(`Sayfa ${currentPage} / ${totalPages}`);
            }

            $prevPage.on('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    renderPage(currentPage);
                }
            });

            $nextPage.on('click', function() {
                const totalPages = Math.ceil(favoriteCustomers.length / itemsPerPage);
                if (currentPage < totalPages) {
                    currentPage++;
                    renderPage(currentPage);
                }
            });

            // İlk sayfayı render et
            renderPage(currentPage);
        });

    </script>

    {{-- search bar script --}}
    <script>
        $(document).ready(function() {
            function filterTable(searchInputId, tableBodyId) {
                $(searchInputId).on('keyup', function() {
                    var value = $(this).val().toLowerCase();
                    console.log(value)

                    $(tableBodyId + ' .user-item').each(function() {
                        var text = $(this).text().toLowerCase();
                        console.log(text)
                        $(this).toggle(text.indexOf(value) > -1);
                    });
                });
            }
        
            // Arama kutuları ve tablo gövdesi
            filterTable('#search-input-yeni', '#user-list-table-body-yeni');
            filterTable('#search-input-geridonus', '#user-list-table-body-geridonus');
            filterTable('#search-input-musteriler', '#user-list-table-body-musteriler');
            filterTable('#search-input-favoriler', '#user-list-table-body-favoriler');
        });
    </script>        
        
    {{-- Takvim kodları --}}
    <script>
        $(document).ready(function () {
            // Danışman renklerini tanımlayın
            var danismanRenkler = @json($danismanRenkler);

            var calendar = $('#calendar').fullCalendar({
                locale: 'tr', // Takvim dilini Türkçe olarak ayarlayın
                events: [
                    @foreach($randevular as $randevu)
                    {
                        id: "{{ $randevu->id }}",
                        title: "{{ $randevu->danisman_adi }}",
                        info: "{{ $randevu->appointment_info }}",
                        start: "{{ $randevu->appointment_date }}", // Tarih ve saat birleşik olarak gösterilebilir
                        allDay: false, // Tüm gün etkinliği olmadığını belirtmek için false yapın
                        danisman_id: "{{ $randevu->danisman_id }}" ,
                        next_meeting_type: "{{ $randevu->sonraki_gorusme_turu }}"
                    },
                    @endforeach
                ],
                displayEventTime: true, // Etkinlik saatini göster
                editable: false, // Düzenleme özelliği kapalı
                eventRender: function (event, element, view) {
                    // Danışman renklerini uygula
                    var danismanRenk = danismanRenkler[event.danisman_id];
                    if (danismanRenk) {
                        element.css('background-color', danismanRenk);
                        element.css('border-color', danismanRenk);
                    }

                    // Tooltips eklemek için
                    element.attr('data-toggle', 'tooltip');
                    element.attr('title', event.title); // Tooltip içeriği olarak etkinlik başlığını kullan

                    // Click işlemi
                    element.click(function() {
                        // Swal ile detay gösterme

                        var meetingTypeText = '';
                        if (event.next_meeting_type === 'Telefon') {
                            meetingTypeText = '<p>Görüşme Türü:<strong class="strongCss"> Telefon</strong></p>';
                        }

                        Swal.fire({
                            title: 'Randevu Detayları',
                            html: `
                                <div style="text-align: left;border: 1px solid #c3c3c3;padding: 19px;border-radius: 10px;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;">
                                    <p>Tarih ve Saat:<strong class="strongCss">${moment(event.start).format('DD-MM-YYYY HH:mm')}</strong></p>
                                    <p>Danışman:<strong class="strongCss"> ${event.title}</strong></p>
                                    <p>Randevu Bilgisi:<strong class="strongCss"> ${event.info}</strong></p>
                                    ${meetingTypeText}
                                </div>
                            `,
                            icon: 'info',
                            confirmButtonText: 'Tamam',
                            customClass: {
                                popup: 'swal-wide'
                            }
                        });
                    });
                }
            });
            $('#appointments-btn').on('click', function(event) {
                $('#randevular').show();
                calendar.fullCalendar('render');
            });
        });
    </script>

    {{-- görüşme değerle js kodları --}}
    <script>
 
        function handleStarPress(index) {
            const stars = document.querySelectorAll('.fa-star, .fa-star-o');

            // Set ratings
            for (let i = 0; i <= index; i++) {
                stars[i].classList.remove('fa-star-o');
                stars[i].classList.add('fa-star');
                stars[i].style.color = 'gold';
            }

            for (let i = index + 1; i < stars.length; i++) {
                stars[i].classList.remove('fa-star');
                stars[i].classList.add('fa-star-o');
                stars[i].style.color = 'gray';
            }

            // Update hidden input value
            const ratingInput = document.getElementById('ratingInput');
            ratingInput.value = index + 1;

            // AJAX request to update rating on server
            fetch('{{ route('institutional.setRating') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ rating: index + 1 })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Rating set successfully');
            })
            .catch(error => {
                console.error('Error setting rating:', error);
            });
        }

    </script>

    {{-- ajax istekleri --}}
    <script>
        //usermodal için
            function fetchUserDetails(itemId) {
                // AJAX isteği
                resetModalContent();
                function resetModalContent() {
                    document.getElementById('new-call-modal-name').innerText = '';
                    document.getElementById('new-call-modal-email').innerText = '';
                    document.getElementById('new-call-modal-phone').innerText = '';
                    document.getElementById('new-call-modal-province').innerText = '';
                    document.getElementById('new-call-modal-ilgilendigi-proje').innerText = '';
                    document.getElementById('new-call-modal-job-title').innerText = '';
                    
                        // Checkbox'ları temizle
                    for (let i = 11; i <= 20; i++) {
                        document.getElementById('checkbox' + i).checked = false;
                    }


                    // Gizli input alanını temizle
                    document.getElementById('customer_id2').value = '';
                }
              
                fetch('/hesabim/musteri/bilgileri/' + itemId)
                    .then(response => response.json())
                    .then(data => {
                    console.log('data'+JSON.stringify(data))
                        // Modal içine verileri yaz                      
                        document.getElementById('user-modal-name').innerText              = data.name;
                        document.getElementById('user-modal-email').innerText             = data.email;
                        document.getElementById('user-modal-phone').innerText             = data.phone.replace('p:+9', '');
                        document.getElementById('user-modal-province').innerText          = data.province;
                        document.getElementById('user-modal-ilgilendigi-proje').innerText = data.project_name;
                        document.getElementById('user-modal-job-title').innerText         = data.job_title;

                                    // Checkbox değerlerini ayarlama
                        document.getElementById('checkbox1').checked  = data.konut_tercihi.includes('Projeden Konut');
                        document.getElementById('checkbox2').checked  = data.konut_tercihi.includes('Hazır Konut');
                        document.getElementById('checkbox3').checked  = data.varlik_yonetimi.includes('Yatırım');
                        document.getElementById('checkbox4').checked  = data.varlik_yonetimi.includes('Oturum');
                        document.getElementById('checkbox5').checked  = data.varlik_yonetimi.includes('Yatırım/Oturum');
                        document.getElementById('checkbox6').checked  = data.musteri_butcesi.includes('0-500.000');
                        document.getElementById('checkbox7').checked  = data.musteri_butcesi.includes('500.000-1.000.000');
                        document.getElementById('checkbox8').checked  = data.musteri_butcesi.includes('2.000.000-4.000.000');
                        document.getElementById('checkbox9').checked  = data.musteri_butcesi.includes('4.000.000-6.000.000');
                        document.getElementById('checkbox10').checked = data.musteri_butcesi.includes('6.000.000 ve üzeri');

                        document.querySelector('select[name="ilgilendigi_bolge"]').value = data.ilgilendigi_bolge;

                         // Checkbox'ları disable yap
                        for (let i = 1; i <= 10; i++) {
                            document.getElementById('checkbox' + i).disabled = true;
                        }


                        $('select[name="ilgilendigi_bolge"]').val(data.ilgilendigi_bolge).prop('disabled', true);

                    })
                    .catch(error => console.error('Error:', error));
            }
        //pastConversationsModal için
            function fetchCustomerCalls(itemId){
                const modalBody = document.getElementById('past-conversations-body');

                modalBody.innerHTML = ''; // Önce mevcut içeriği temizle

                // AJAX isteği
                fetch('/hesabim/musteri/gecmis/aramalari/' + itemId)
                .then(response => response.json())
                .then(data => {

                    if (data.message) {
                        // Eğer geçmiş görüşme kaydı yoksa mesaj göster
                       modalBody.innerHTML = '<p class="form-control" style="padding: 21px 0px 40px 30px !important;color: #333 !important;font-size: 12px !important;">Müşterinizin geçmiş arama kaydı bulunmamaktadır.</p>';
                    } 
                    else {
                            // Geçmiş görüşme kayıtlarını modal içine yaz
                            data.forEach(conversation => {
                                const conversationDiv = document.createElement('div');
                                conversationDiv.classList.add('customerInfo', 'mb-3');
                                conversationDiv.style.cssText = 'padding: 20px 30px !important;box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;';
                                conversationDiv.innerHTML = `
                                <p>Görüşme Tarihi: <strong class="strongCss">${conversation.meeting_date}</strong></p>
                                <p>Görüşme Sonucu: <strong class="strongCss">${conversation.conclusion}</strong></p>
                                <p>Görüşme Türü:   <strong class="strongCss">${conversation.meet_type}</strong></p>
                                <p>Görüşme Notu:   <strong class="strongCss">${conversation.note}</strong></p>
                                `;
                                modalBody.appendChild(conversationDiv);
                        });
                    }

                })
                .catch(error => console.error('Error:', error));            
            }

        // newCallModal için
            function addNewCall(itemId) {
                 // Modal içeriğini sıfırla
                resetModalContent();
                function resetModalContent() {
                    document.getElementById('new-call-modal-name').innerText = '';
                    document.getElementById('new-call-modal-email').innerText = '';
                    document.getElementById('new-call-modal-phone').innerText = '';
                    document.getElementById('new-call-modal-province').innerText = '';
                    document.getElementById('new-call-modal-ilgilendigi-proje').innerText = '';
                    document.getElementById('new-call-modal-job-title').innerText = '';
                    
                    //Checkbox'ları temizle
                    for (let i = 11; i <= 20; i++) {
                        document.getElementById('checkbox' + i).checked = false;
                    }
                    
                    // // Selectbox'ı temizle
                    // $('select[name="ilgilendigi_bolge"]').val('').prop('disabled', true);

                    // Gizli input alanını temizle
                    document.getElementById('customer_id2').value = '';
                }
                fetch('/hesabim/musteri/bilgileri/' + itemId)
                    .then(response => response.json())
                    .then(data => {
                        console.log(JSON.stringify(data))
                        document.getElementById('customer_id2').value = data.id;
                  
                        // Modal içine verileri yaz
                            document.getElementById('new-call-modal-name').innerText              = data.name;
                            document.getElementById('new-call-modal-email').innerText             = data.email;
                            document.getElementById('new-call-modal-phone').innerText             = data.phone.replace('p:+', '');
                            document.getElementById('new-call-modal-province').innerText          = data.province;
                            document.getElementById('new-call-modal-ilgilendigi-proje').innerText = data.project_name;
                            document.getElementById('new-call-modal-job-title').innerText         = data.job_title;
                        
                                    // Checkbox değerlerini ayarlama
                            document.getElementById('checkbox11').checked  = data.konut_tercihi.includes('Projeden Konut');
                            document.getElementById('checkbox12').checked  = data.konut_tercihi.includes('Hazır Konut');
                            document.getElementById('checkboxArsa').checked  = data.konut_tercihi.includes('Arsa');
                            document.getElementById('checkbox13').checked  = data.varlik_yonetimi.includes('Yatırım');
                            document.getElementById('checkbox14').checked  = data.varlik_yonetimi.includes('Oturum');
                            document.getElementById('checkbox15').checked  = data.varlik_yonetimi.includes('Yatırım/Oturum');
                            document.getElementById('checkbox16').checked  = data.musteri_butcesi.includes('0-500.000');
                            document.getElementById('checkbox17').checked  = data.musteri_butcesi.includes('500.000-1.000.000');
                            document.getElementById('checkbox18').checked  = data.musteri_butcesi.includes('2.000.000-4.000.000');
                            document.getElementById('checkbox19').checked  = data.musteri_butcesi.includes('4.000.000-6.000.000');
                            document.getElementById('checkbox20').checked  = data.musteri_butcesi.includes('6.000.000 ve üzeri');

                            document.querySelector('select[name="ilgilendigi_bolge"]').value = data.ilgilendigi_bolge;
                       

                        })
                        .catch(error => console.error('Error:', error));
                }

                document.addEventListener('DOMContentLoaded', function () {
                    $('#newCallsModal form').off('submit').on('submit', function (e) {
                  
                        e.preventDefault();
                        var formData = new FormData(this);
                        // var customerId = document.getElementById('customer_id2').value;
                        // formData.append('customer_id2xx', customerId);
        
                        fetch('/hesabim/arama/kaydi/musteri/bilgisi/ekle', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Başarılı',
                                    text: data.message 
                                }).then(() => {
                                    $('#newCallsModal').modal('hide');

                                    // Modal kapandıktan sonra overlay'i kaldır
                                    $('body').removeClass('modal-open');
                                    $('.modal-backdrop').remove();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Hata',
                                    text: data.message // Burada da `data.message` kullanın
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata',
                                text: 'Bir hata oluştu, lütfen tekrar deneyin.'
                            });
                            console.error('Error:', error);
                        });
                    });
            });

            // #musteriEklemeModal için
            $(document).ready(function() {
                $('#musteriEklemeForm').on('submit', function(e) {
                    e.preventDefault(); // Formun varsayılan gönderim işlemini engelle

                    // Form verilerini topla
                    var formData = $(this).serialize();

                    $.ajax({
                        type: 'POST',
                        url: '/hesabim/danisman/musteri/ekleme', 
                        data: formData,
                        success: function(response) {
                            // Başarılı AJAX isteği sonrasında yapılacak işlemler
                            Swal.fire({
                                title: 'Başarılı!',
                                text: 'Müşteri başarıyla eklendi!',
                                icon: 'success',
                                confirmButtonText: 'Tamam'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#musteriEklemeModal').modal('hide'); 
                                }
                            });
                        },
                        error: function(response) {
                            // Hatalı AJAX isteği sonrasında yapılacak işlemler
                            alert('Bir hata oluştu, lütfen tekrar deneyin.');
                        }
                    });
                });
            });

    </script>

    {{-- sayfalar arası geçiş Butonları --}}
    <script>
        $(document).ready(function() {
            $('#all-customers-btn').on('click', function(event) {
             
                $('#page-header-title').text('Müşteriler');
                $('#tumMusteriler').show(); 
                $('#yeniMusteriler').hide();
                $('#favoriMusteriler').hide(); 
                $('#geriDonusYapilacakMusteriler').hide();
                $('#randevular').hide(); 
                $('.btn').removeClass('active'); 
                $(this).addClass('active'); 
            });

            $('#new-customers-btn').on('click', function(event) {
                $('#page-header-title').text('Yeni Müşteriler');
             $('#yeniMusteriler').show(); 
             $('#tumMusteriler').hide(); 
             $('#geriDonusYapilacakMusteriler').hide(); 
             $('#favoriMusteriler').hide(); 
             $('#randevular').hide(); 
             $('.btn').removeClass('active'); 
             $(this).addClass('active'); 
         });

         $('#favorite-customers-btn').on('click', function(event) {
            $('#page-header-title').text('Favori Müşteriler');
             $('#favoriMusteriler').show(); 
             $('#yeniMusteriler').hide(); 
             $('#tumMusteriler').hide(); 
             $('#randevular').hide(); 
             $('#geriDonusYapilacakMusteriler').hide(); 
             $('.btn').removeClass('active');
             $(this).addClass('active'); 
         });

         
         $('#follow-up-customers-btn').on('click', function(event) {
            $('#page-header-title').text('Dönüş Yapılacak Müşteriler');
             $('#geriDonusYapilacakMusteriler').show(); 
             $('#favoriMusteriler').hide(); 
             $('#yeniMusteriler').hide(); 
             $('#tumMusteriler').hide(); 
             $('#randevular').hide(); 
             $('.btn').removeClass('active');
             $(this).addClass('active'); 
         });

         $('#appointments-btn').on('click', function(event) {
            $('#page-header-title').text('Randevu Takvimi');
             $('#randevular').show(); 
             $('#favoriMusteriler').hide(); 
             $('#yeniMusteriler').hide(); 
             $('#geriDonusYapilacakMusteriler').hide(); 
             $('#tumMusteriler').hide(); 
             $('.btn').removeClass('active');
             $(this).addClass('active'); 
         });

        });

    </script>

    {{-- favori ekleme ajax js --}}
    <script>
        function toggleFavorite(itemId) {
            // Kullanıcının favoride olup olmadığını kontrol etmek için AJAX isteği
            $.ajax({
                url: `/hesabim/check-favorite/${itemId}`,
                type: 'GET',
                success: function(response) {
                    let confirmationText = response.isFavorited ? 'favoriden kaldırmak' : 'favoriye eklemek';
                    
                    Swal.fire({
                        title: `Bu müşteriyi ${confirmationText} istediğinize emin misiniz?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Evet',
                        cancelButtonText: 'Hayır'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Favori ekleme veya kaldırma işlemi
                            $.ajax({
                                url: `/hesabim/toggle-favorite/${itemId}`,
                                type: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    let btn = $(`#favorite-btn-${itemId} i`);
                                    if (response.isFavorited) {
                                        btn.removeClass('fa-heart-broken').addClass('fa-heart');
                                    } else {
                                        btn.removeClass('fa-heart').addClass('fa-heart-broken');
                                    }
                                    Swal.fire({
                                        title: response.message,
                                        icon: 'success'
                                    });
                                },
                                error: function() {
                                    Swal.fire({
                                        title: 'Bir hata oluştu!',
                                        icon: 'error'
                                    });
                                }
                            });
                        }
                    });
                },
                error: function() {
                    Swal.fire({
                        title: 'Bir hata oluştu!',
                        icon: 'error'
                    });
                }
            });
        }
    </script>
@endsection

@section('styles')

    {{-- modal boyutu kontrolü --}}
    <style> 
        .modal-dialog {
            margin-top: 8%;
            height: 90%;
        }
        .modal-content {
            background-color: ghostwhite; /* Kürt Gri */
        }
        #pastConversationsModal .modal-body {
            max-height: 70vh; /* Modalın gövdesinin maksimum yüksekliği */
            overflow-y: auto; /* Dikey kaydırma */
            overflow-x: hidden; /* Yatay kaydırmayı gizle */
        }

        .modal-body {
            max-height: 90vh;
            overflow-y: auto;
        }

    </style>

    {{-- yıldızların css --}}
    <style>
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
        }
        .rating label:before {
            content: '\2605';
            padding: 5px;
            font-size: 30px;
        }
        .rating input:checked ~ label {
            color: #fdd835;
        }
    </style>

    <style>
        .project-table-content ul li {
            flex: none !important;  
        }
        .search-input {
            width: 21%;
            margin-top: 8px;
        }

        .page-header-title2{
            background: linear-gradient(to top, #EC2F2E, #84181A);  
            padding: 10px;
            font-size: 18px;
            color: white;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 40px;
        }
        .swal-wide {
            width: 600px !important;
        }
        #calender{
            padding: 12px;
        }
        
        .form-control{
            border:1px solid rgb(199 198 198) !important;
        }

        .favorited {
            background-color: white;
            color: #EC2F2E;

                border: 1px solid #EC2F2E;
                margin: 2px;
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 12px;
                display: inline-block; /* Butonları tek satırda gösterir */
                border-radius: 4px !important;
        }
        .not-favorited {
            background-color: #EC2F2E;
                border: 1px solid #EC2F2E;
                color: white;
                margin: 2px;
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
                font-size: 12px;
                display: inline-block; /* Butonları tek satırda gösterir */
                border-radius: 4px !important;
        }
        .strongCss{
            font-weight: bold !important;
            font-size: 12px;
            margin-left: 7px;
            color: #464646ed;
        }
         
        .customerInfo{
            padding:10px;
            margin-left: 0px;
            border:1px solid rgb(211, 211, 211);
            border-radius:5px;
            box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
            background-color: white; 
            margin-right:0px
        }

        label {
            color: #000000 !important;
        }

        .sales-consultants-heading {
            font-size: 2.2em;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            position: relative;
        }
        .sales-consultants-heading::after {
            content: '';
            display: block;
            margin: 0 auto;
            width: 50%; /* Çizgi genişliğini ayarla */
            padding-top: 10px;
            border-bottom: 2px solid gray;
        }
        .text-header{
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 18px;
        }
        .text-header-title{
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 18px;
        }
        .btnProjectAssign{
            width: 100%;
            border-color: #333;
            background-color: #333;
            color: white;
        }
        .btnProjectAssign:hover{
            background-color: white !important;
            color: #333;
            border-color: #333;
        }  

        .checkbox-title {
            color: #000000 !important; 
            font-size: 12px; 
            text-decoration: underline; 
            font-weight: bold; /* Make the text bold for sharpness */
            }
    </style>

    {{-- btn css --}}
    <style>
        .inputMusteriEkle{
            display: block;
            width: 100%;
            padding: 1rem 1rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.45rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            margin-bottom: 9px;
        }

        .btn {
            width: 17%;
            font-size: 10px !important;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
            padding: 10px 2px;
            margin-right: 10px;
            background-color: #333;
            color: white;
            /* display: flex; */
            flex-direction: column;
            align-items: center;
        }

        #btnMusteriEkle{
            margin: 5px 8px 20px 0px;
            float: inline-end;
            border-radius: 6px !important;
            width: 17%;
            font-size: 10px !important;
            padding: 10px 2px;
            background-color: #333;
            color: white;
            flex-direction: column;
            align-items: center;
        }

        .btnDanisman {
            width: 17%;
            font-size: 10px !important;
            border-top-right-radius: 5px;
            border-top-left-radius: 5px;
            padding: 10px 2px;
            margin-right: 10px;
            background-color: #333;
            color: white;
            /* display: flex; */
            flex-direction: column;
            align-items: center;
        }

        .whatsapp-btn {
            background-color: #25D366; /* WhatsApp yeşil rengi */
            border: none;
            color: white;
            padding: 8px 11px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 8px;
            margin: 3px 2px;
            cursor: pointer;
            border-radius: 18% !important;
            transition: background-color 0.3s;
        }

        .whatsapp-btn i {
            font-size: 14px; 
        }

        .whatsapp-btn:hover {
            background-color: #128C7E; 
        }

        .count {
            display: block;
            margin-bottom: 15px; 
        }

        .btn:hover{
            background-color: white !important;
            color: #333;
            border-color: #333 !important;
        }

        .btn.active {
            background-color: #EC2F2E !important;
            color: white !important;
            border-color: #EC2F2E !important;
        }

        .btn.active:hover{
            background-color: white !important;
            color: #EC2F2E !important;
            border-color: #EC2F2E !important;
        }

        .action-btn {
            background-color: #EC2F2E;
            border: 1px solid #EC2F2E;
            color: white;
            margin: 2px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            display: inline-block; 
            border-radius: 4px !important;
        }

        .action-btn i {
            margin-right: 0; 
        }

        .action-btn:hover {
            background-color: white;
            color: #EC2F2E;
        }

        .action-buttons {
            white-space: nowrap; 
        }

        .action-buttons button:focus,
        .action-buttons a:focus {
            outline: none;
            /* box-shadow: none; */
        }

        .action-btn-blue {
            background-color: #2f5f9e;
            border: 1px solid #2f5f9e;
            color: white;
            margin: 2px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            display: inline-block; 
            border-radius: 4px !important;
        }

        .action-btn-blue:hover {
            background-color: white;
            color: #2f5f9e;
        }
        .action-btn-blue:hover i {
            color: #2f5f9e;
        }

        .btnSubmit{
            background-color: #EC2F2E !important;
            border: 1px solid #EC2F2E !important;
            color: white;
            margin: 2px;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            display: inline-block; /* Butonları tek satırda gösterir */
            border-radius: 4px !important;
        }

        .btnSubmit:hover{
            background-color: white !important;
            color: #EC2F2E !important;
            border: 1px solid #EC2F2E !important;
        }     

    </style>

@endsection
